<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wish;
use Faker\Generator as Faker;

$factory->define(Wish::class, function (Faker $faker) {
    return [
        'title' => $faker->safeColorName,
        'description' => $faker->text(),
        'link' => $faker->url,
        'filename' => $faker->imageUrl(),
        'priority' => array_keys(wish_priorities)[rand(0, count(array_keys(wish_priorities))-1)],
        'status' => rand(0, 2),
        'user_id' => array(null, rand(1, 10))[rand(0,1)],
        'wish_box_id' => rand(1, N_WISHBOXES),
        'category_id' => rand(1, 10),
    ];
});
