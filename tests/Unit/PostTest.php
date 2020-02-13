<?php

namespace Tests\Unit;

use App\Actions\Post\UpsertPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_new_post()
    {
        $title = $this->faker->sentence;

        factory(Post::class)->create(compact('title'));

        $this->assertDatabaseHas('posts', compact('title'));
    }

    public function test_create_new_published_post()
    {
        $title = $this->faker->sentence;

        $post = factory(Post::class)->states('published')
            ->create(compact('title'));

        $this->assertDatabaseHas('posts', compact('title'));

        $this->assertTrue($post->isPublished());
    }

    public function test_create_new_scheduled_post()
    {
        $title = $this->faker->sentence;

        $post = factory(Post::class)->states('scheduled')
            ->create(compact('title'));

        $this->assertDatabaseHas('posts', compact('title'));

        $this->assertTrue($post->isScheduled());
    }

    public function test_create_and_update_post_using_action()
    {
        $this->actingAs(
            $user = factory(User::class)->create()
        );

        $post = UpsertPost::execute($data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(5, true),
        ]);

        $this->assertDatabaseHas('posts', $data);

        $this->assertNotNull($post);
        $this->assertFalse($post->isPublished());
        $this->assertSame($post->user, $user);

        $published = UpsertPost::execute([
            'post' => $post,
            'title' => $title = $this->faker->sentence,
            'publish' => 1,
        ]);

        $this->assertDatabaseHas('posts', compact('title'));

        $this->assertTrue($published->isPublished());

        $unpublished = UpsertPost::execute([
            'post' => $post,
            'unpublish' => 1,
        ]);

        $this->assertFalse($unpublished->isPublished());

        $scheduled = UpsertPost::execute([
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(5, true),
            'schedule' => now()->addDays(2),
        ]);

        $this->assertTrue($scheduled->isScheduled());
    }
}
