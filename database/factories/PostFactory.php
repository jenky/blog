<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraphs(5, true),
        'user_id' => factory(User::class),
    ];
});

$factory->state(Post::class, 'published', [
    'published_at' => now(),
]);
