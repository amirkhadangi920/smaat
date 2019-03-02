<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        
        'info'      => $faker->name(),  
        'logo'      => [ null, $faker->imageUrl() ][ $faker->boolean() ],
        'cost'      => $faker->numberBetween( 1000 , 9000),
        'minimum'   => $faker->numberBetween(0,1000),
        'is_active' => $faker->boolean 
        
    ];
});
