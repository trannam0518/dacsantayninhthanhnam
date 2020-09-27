<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderDetails;
use Faker\Generator as Faker;

$factory->define(OrderDetails::class, function (Faker $faker) {
    return [
        'order_detail_order_id' => $faker->numberBetween('1','20'),
        'order_detail_product_id' => $faker->numberBetween('1','20'),
        'order_detail_price'=>$faker->numberBetween('50000','100000000'),
        'order_detail_quantity'=>$faker->randomDigit,
        'order_detail_unit'=>$faker->word,
        'order_detail_price_transport' => $faker->numberBetween('50000','100000000'),
    ];
});
