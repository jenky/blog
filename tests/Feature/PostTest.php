<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function test_create_new_post()
    {
        $this->get(route('posts.create'))
            ->assertRedirect(route('login'));

        $this->post(route('posts.store'), [
                'title' => $this->faker->sentence,
                'content' => $this->faker->paragraphs(5, true),
            ])
            ->assertRedirect(route('login'));

        $this->actingAs($this->user)
            ->get(route('posts.create'))
            ->assertOk();

        $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'title' => '',
                'content' => '',
            ])
            ->assertSessionHasErrors(['title', 'content'])
            ->assertRedirect();

        $this->actingAs($this->user)
            ->post(route('posts.store'), $data = [
                'title' => $this->faker->sentence,
                'content' => $this->faker->paragraphs(5, true),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    public function test_create_and_publish_post()
    {
        $this->actingAs($this->user)
            ->post(route('posts.store'), $data = [
                'title' => $title = '__foo__',
                'content' => $this->faker->paragraphs(5, true),
                'publish' => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', Arr::except($data, 'publish'));

        $post = Post::where('title', $title)->first();

        $this->assertNotNull($post);

        $this->assertTrue($post->isPublished());
    }

    public function test_edit_post()
    {
        $post = factory(Post::class)->create();

        $this->assertNotNull($post);

        $this->actingAs($this->user)
            ->put(route('posts.update', $post), [
                'title' => $this->faker->sentence,
                'content' => $this->faker->paragraphs(5, true),
            ])
            ->assertForbidden();

        $this->actingAs($post->user)
            ->put(route('posts.update', $post), $data = [
                'title' => $this->faker->sentence,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);

        $admin = factory(User::class)->states('admin')
            ->create()
            ->fresh();

        $this->actingAs($admin)
            ->put(route('posts.update', $post), $data = [
                'title' => $this->faker->sentence,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    public function test_delete_post()
    {
        $posts = factory(Post::class, 2)->create();

        [$post1, $post2] = $posts->all();

        $this->assertNotNull($post1);
        $this->assertNotNull($post2);

        $this->actingAs($this->user)
            ->delete(route('posts.destroy', $post1))
            ->assertForbidden();

        $this->actingAs($post1->user)
            ->delete(route('posts.destroy', $post1))
            ->assertRedirect();

        $this->assertDeleted($post1);

        $admin = factory(User::class)->states('admin')
            ->create()
            ->fresh();

        $this->actingAs($admin)
            ->delete(route('posts.destroy', $post2))
            ->assertRedirect();

        $this->assertDeleted($post2);
    }

    public function test_schedule_post()
    {
        $post = factory(Post::class)
            ->state('scheduled')
            ->create();

        $this->get(route('posts.show', $post))
            ->assertNotFound();

        $this->actingAs($post->user)
            ->get(route('posts.show', $post))
            ->assertOk();

        $admin = factory(User::class)->states('admin')
            ->create()
            ->fresh();

        $this->actingAs($admin)
            ->get(route('posts.show', $post))
            ->assertOk();
    }
}
