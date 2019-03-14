<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Financial\ShippingMethod::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        
        'name'                => [ 'هوایی ', 'زمینی', 'پست معمولی', 'قطار', 'پیک', 'حضوری', 'کشتی', 'پست پیشتاز' ][ rand( 0, 7)],
        'description'       => [ null, Faker::sentence() ][ $faker->boolean() ],  
        'logo'                  => nullable( image ( $brands[$selected]['logo'] )),
        'cost'                   => $faker->numberBetween( 1000, 900000000),
        'minimum'          => $faker->numberBetween(0,1000),
        'is_active'            => $faker->boolean() 
        
    ];
});
