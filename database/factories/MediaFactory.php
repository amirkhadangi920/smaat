<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'collection_name'   => $faker->sentence(),
        'name'              => $faker->name(),
        'file_name'         => $faker->sentence(),
        'mime_type'         => $faker->sentence(),
        'disk'              => $faker->sentence(),
        'size'              => $faker->numberBetween( 10 , 100000 ),
        'manipulations'     => $faker->text,
        'custom_properties' => $faker->text,
        'responsive_images' => $faker->text,
        'order_column'      => $faker->numberBetween( 10 , 100000 )

    ];
});