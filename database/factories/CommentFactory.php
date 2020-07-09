<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    $posts = App\Post::pluck('id')->toArray();

    return [
        'user_id' => $faker->randomElement($users),
        'post_id' => $faker->randomElement($posts),
        'comment' => $faker->text(50),
    ];
});
