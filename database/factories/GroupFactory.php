<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Group\Category::class, function () use($faker, $brands) {
    
    $selected = rand(0, count($brands) - 1);
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Group\ScoringField::class, function () use($faker, $brands) {
    
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'default'           => $faker->numberBetween(0, 5),
    ];
});

$factory->define(App\Models\Group\Subject::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
        
    ];
});

$factory->define(App\Models\Group\AccountGroup::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'depth'             => $faker->numberBetween(1, 5),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
    ];
});