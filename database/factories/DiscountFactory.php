<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Discount::class, function (Faker $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => $faker->sentence(),
        'logo'          => $faker->imageUrl(200,200),
        'type'          => $faker->numberBetween(0 , 225),
        'status'        => $faker->numberBetween(0 , 225),
        'start_at'      => $faker->dateTime(),
        'expired_at'    => $faker->dateTime()
    ];
});


$factory->define(Model::class, function (Faker $faker) {
    return [
        'offer'         => $faker->numberBetween(1000 , 50000),
        'quantity'      => $faker->numberBetween(20000 , 50000),
        'sold_count'    => $faker->numberBetween(1000 , 500000),
    ];
});
