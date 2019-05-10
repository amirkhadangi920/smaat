<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Promocode\Promocode::class, function () use($faker) {
    return [
        'code'       => $faker->text(50),
        'value'      => $faker->numberBetween( 1 , 99 ),
        'min_total'  => $faker->numberBetween( 0 , 50000 ),
        'max'        => $faker->numberBetween( 10000 , 100000 ),
        'quantity'   => nullable( $faker->numberBetween(1, 100) ),
        'reward_type'=> [ 'تولد' , 'هدیه' , 'خرید' ][rand(0,2)],
        'expired_at' => $faker->dateTimeBetween('now', '+6 months')
    ];
});

$factory->define(App\Models\Promocode\PromocodeUser::class, function () use($faker) {
    return [
        'is_used'    => $faker->boolean(),
        'used_at'    => nullable( $faker->dateTimeBetween('now', '-2 years') )
    ];
});
