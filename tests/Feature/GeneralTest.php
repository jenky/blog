<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register()
    {
        $this->post(route('register'), $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => '__password__',
            'password_confirmation' => '__password__',
        ])->assertRedirect();

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', Arr::except(
            $data, ['password', 'password_confirmation']
        ));
    }

    public function test_fail_register()
    {
        $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('password');

        $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => 'wrong-format',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors(['email', 'password']);

        $this->post(route('register'), [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'abc',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors(['password']);
    }

    public function test_login()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_fail_login()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), [
            'email' => 'email@not-existed.error',
            'password' => 'password',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors(['email']);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors();
    }
}
