<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_posts()
    {
        $this->get(route('posts.create'))
            ->assertRedirect(route('login'));

        $this->actingAs(
                factory(User::class)->create()
            )
            ->get(route('posts.create'))
            ->assertOk();
    }
}
