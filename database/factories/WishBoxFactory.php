<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WishBox;
use Faker\Generator as Faker;

$factory->define(WishBox::class, function (Faker $faker) {

    return [
        'title' => $faker->jobTitle,
        'deadline' => $faker->date(),
        'visibility' => array_keys(visibilities)[rand(0, count(array_keys(visibilities))-1)],
        'type' => array_keys(wish_types)[rand(0, count(wish_types)-1)],
        'user_id' => rand(1, 10),
    ];
});
