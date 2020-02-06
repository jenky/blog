<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_new_user()
    {
        $name = $this->faker->name;

        factory(User::class)->create(compact('name'));

        $this->assertDatabaseHas('users', compact('name'));
    }

    public function test_create_new_admin()
    {
        $name = $this->faker->name;

        $admin = factory(User::class)->states('admin')
            ->create(compact('name'));

        $this->assertDatabaseHas('users', compact('name'));

        // Use fresh() to reload the model instance.
        $this->assertTrue($admin->fresh()->isAdmin());
    }
}
