<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Promocede\Promocode::class, function (Faker $faker) {
    return [
        'code'       => $faker->sentence(50),
        'value'      => $faker->numberBetween( 1000 , 50000 ),
        'min_total'  => $faker->numberBetween( 0 , 50000 ),
        'reward_type'=> [ 'birthday' , 'gift' , 'buy' ][rand(0,2)],
        'expired_at' => $faker->dateTime()
    ];
});

$factory->define(Model::class, function (Faker $faker) {
    return [
        'is_used'    => $faker->boolean(),
        'used_at'    => nullable( $faker->dateTime() )
    ];
});
