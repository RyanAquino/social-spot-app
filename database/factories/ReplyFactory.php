<?php

use Faker\Generator as Faker;

$factory->define(App\Reply::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    $comment = App\User::pluck('id')->toArray();
    
    return [
        'comment_id' => $faker->randomElement($comment),
        'user_id' => $faker->randomElement($users),
        'reply' => $faker->text(15),
    ];
});
