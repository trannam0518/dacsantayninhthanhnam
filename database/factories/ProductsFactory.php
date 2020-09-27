<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'product_name' => $faker->name,
        'product_image' => $faker->imageUrl(),
        'product_status' => $faker->numberBetween($min = 1, $max = 1) ,
    ];
});
