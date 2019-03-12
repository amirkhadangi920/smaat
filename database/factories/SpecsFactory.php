<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Spec\Spec::class, function () use($faker) {
    return [
        'title'         => $faker->name(),
        'description'   => [ null, Faker::sentence() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Spec\SpecHeader::class, function () use($faker) {
    return [
        'title'         => $faker->name(),
        'description'   => [ null, Faker::sentence() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Spec\SpecRow::class, function () use($faker) {
    $multiple = $faker->numberBetween(0, 1);

    return [
        'title'         => $faker->name(),
        'description'   => [ null, Faker::sentence()  ][ $faker->boolean() ],
        'label'         => [ null, $faker->name() ][ $faker->boolean() ],
        'values'        => ($multiple) ? rand(0,1) ? $faker->words(rand(1, 10)) : null : null,
        'help'          => [ null, Faker::sentence() ][ $faker->boolean() ],
        'multiple'      => $multiple,
        'required'      => $faker->boolean()
    ];
});

$factory->define(App\Models\Spec\SpecData::class, function () use($faker) {
    return [
        'data'  => $faker->company
    ];
});