<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Promocode\Promocode::class, function () use($faker) {
    return [
        'code'       => $faker->text(50),
        'value'      => $faker->numberBetween( 1000 , 50000 ),
        'min_total'  => $faker->numberBetween( 0 , 50000 ),
        'reward_type'=> [ 'تولد' , 'هدیه' , 'خرید' ][rand(0,2)],
        'expired_at' => $faker->dateTime()
    ];
});

$factory->define(App\Models\Promocode\PromocodeUser::class, function () use($faker) {
    return [
        'is_used'    => $faker->boolean(),
        'used_at'    => nullable( $faker->dateTime() )
    ];
});
