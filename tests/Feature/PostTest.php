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

        $admin = factory(User::class)->states('admin')->create();

        $this->actingAs($admin->fresh())
            ->put(route('posts.update', $post), $data = [
                'title' => $this->faker->sentence,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }
}
