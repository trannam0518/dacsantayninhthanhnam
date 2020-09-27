<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customers;
use Faker\Generator as Faker;

$factory->define(Customers::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name,
        'customer_address' => $faker->address,
        'customer_phone' => $faker->phoneNumber,
        'customer_status' =>$faker->numberBetween($min = 1, $max = 1) 
    ];
});
