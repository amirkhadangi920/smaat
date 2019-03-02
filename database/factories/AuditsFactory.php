<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'user_type' => $faker->name(),
        'event'     => $faker->sentence(),
        'old_values'=> $faker->text,
        'new_values'=> $faker->text,
        'url'       => $faker->text,
        'ip_address'=> $faker->creditCardNumber,
        'user_agent'=> $faker->sentence(),
        'tags'      => $faker->sentence(),
    ];
});
