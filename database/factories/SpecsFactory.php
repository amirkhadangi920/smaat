<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Spec\Spec::class, function (Faker $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Spec\SpecHeader::class, function (Faker $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Spec\SpecRow::class, function (Faker $faker) {
    $multiple = $faker->numberBetween(0, 1);

    return [
        'title'         => $faker->name(),
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ],
        'label'         => [ null, $faker->name() ][ $faker->boolean() ],
        'values'        => ($multiple) ? rand(0,1) ? $faker->words(rand(1, 10)) : null : null,
        'help'          => [ null, $faker->sentence() ][ $faker->boolean() ],
        'multiple'      => $multiple,
        'required'      => $faker->boolean()
    ];
});

$factory->define(App\Models\Spec\SpecData::class, function (Faker $faker) {
    return [
        'data'  => $faker->company
    ];
});