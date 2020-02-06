<?php

namespace Tests\Unit;

use App\Models\Post;
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
}
