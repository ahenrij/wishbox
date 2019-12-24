<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserCategory;
use Faker\Generator as Faker;

$factory->define(UserCategory::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 10),
        'category_id' => rand(1, 10),
    ];
});
