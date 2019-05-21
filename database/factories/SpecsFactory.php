<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Spec\Spec::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => $faker->name(),
        'description'       => [ null, Faker::sentence() ][ $faker->boolean() ],
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Spec\SpecHeader::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'         => $faker->name(),
        'description'   => [ null, Faker::sentence() ][ $faker->boolean() ],
        'is_active'     => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Spec\SpecRow::class, function () use($faker) {
    $multiple = $faker->numberBetween(0, 1);

    return [
        'user_id'           => App\User::all()->random()->id,
        'title'         => $faker->name(),
        'description'   => [ null, Faker::sentence()  ][ $faker->boolean() ],
        'label'         => [ null, $faker->name() ][ $faker->boolean() ],
        'values'        => ($multiple) ? rand(0,1) ? $faker->words(rand(1, 10)) : null : null,
        'help'          => [ null, Faker::sentence() ][ $faker->boolean() ],
        'multiple'      => $multiple,
        'required'      => $faker->boolean(),
        'is_active'     => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Spec\SpecData::class, function () use($faker) {
    return [
        'data'  => $faker->company
    ];
});