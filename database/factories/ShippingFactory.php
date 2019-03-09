<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Financial\ShippingMethod::class, function (Faker $faker) {
    return [
        
        'name'           => $faker->name(),
        'description'     => $faker->sentence(),  
        'logo'            => [ null, $faker->imageUrl() ][ $faker->boolean() ],
        'cost'            => $faker->numberBetween( 1000 , 9000),
        'minimum'         => $faker->numberBetween(0,1000),
        'is_active'       => $faker->boolean 
        
    ];
});
