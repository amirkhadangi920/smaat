<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Financial\ShippingMethod::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'user_id'           => App\User::all()->random()->id,        
        'name'              => [ 'هوایی ', 'زمینی', 'پست معمولی', 'قطار', 'پیک', 'حضوری', 'کشتی', 'پست پیشتاز' ][ rand( 0, 7)],
        'description'       => [ null, Faker::sentence() ][ $faker->boolean() ],  
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'cost'              => $faker->numberBetween( 1000, 900000000),
        'minimum'           => $faker->numberBetween(0,1000),
        'is_active'         => $faker->boolean(),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});
