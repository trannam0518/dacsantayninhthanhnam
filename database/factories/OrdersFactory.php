<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orders;
use Faker\Generator as Faker;

$factory->define(Orders::class, function (Faker $faker) {
    return [
        'order_customer_id' =>  $faker->numberBetween('1','20'),
        'order_date_completed' => $faker->dateTime,
        'order_status' => $faker->numberBetween('1','2'),
        'order_note'=> $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});
