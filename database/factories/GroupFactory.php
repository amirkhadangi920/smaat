<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Group\Category::class, function () use($faker, $brands) {
    
    $selected = rand(0, count($brands) - 1);
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'scoring_feilds'    => nullable( function () use ( $faker ) {
            $feilds = [];
            for ($i = 0; $i < rand(1, 8); ++$i)
                $feilds[] = Faker::sentence();
            return $feilds;
        })
    ];
});

$factory->define(App\Models\Group\Subject::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
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