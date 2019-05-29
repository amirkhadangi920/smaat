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
        'description'   => nullable( Faker::sentence() ),
        'is_active'     => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Spec\SpecRow::class, function () use($faker) {

    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => $faker->name(),
        'description'       => nullable( Faker::sentence() ),
        'prefix'            => nullable( $faker->name() ),
        'postfix'           => nullable( $faker->name() ),
        'help'              => nullable( Faker::sentence() ),
        'is_detailable'     => $faker->boolean(10),
        'is_filterable'     => $faker->boolean(30),
        'is_multiple'       => $faker->boolean(),
        'is_required'       => $faker->boolean(),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Spec\SpecDefault::class, function () use($faker) {

    return [
        'value'         => [ $faker->name(), Faker::sentence()][ $faker->boolean(60) ],
    ];
});

$factory->define(App\Models\Spec\SpecData::class, function () use($faker) {
    return [
        'data'  => $faker->company
    ];
});