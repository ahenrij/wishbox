<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Wish;
use Faker\Generator as Faker;

$factory->define(Wish::class, function (Faker $faker) {
    return [
        'description' => $faker->text(),
        'link' => $faker->url,
        'filename' => $faker->url,
        'priority' => array_keys(wish_priorities)[rand(0, count(array_keys(wish_priorities))-1)],
        'user_id' => rand(1, 10),
        'wish_box_id' => rand(1, 10),
        'category_id' => rand(1, 10),
    ];
});
