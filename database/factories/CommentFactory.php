<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'message' => $faker->realText('191'),
        'date' => $faker->dateTime(),
        'user_id' => rand(1, 10),
        'wish_id' => rand(1, 10),
    ];
});
