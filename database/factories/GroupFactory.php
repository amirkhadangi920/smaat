<?php

use Faker\Generator as FakerEng;

$factory->define(App\Models\Group\Category::class, function (FakerEng $faker) {
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( $faker->imageUrl(100, 100) ),
        'scoring_feilds'    => nullable( function () use ( $faker ) {
            $feilds = [];
            for ($i = 0; $i < rand(1, 8); ++$i)
                $feilds[] = $faker->sentence();
            return $feilds;
        })
    ];
});

$factory->define(App\Models\Group\Subject::class, function (FakerEng $faker) {
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'logo'              => nullable( $faker->imageUrl(100, 100) ),
    ];
});

$factory->define(App\Models\Group\AccountGroup::class, function (FakerEng $faker) {
    return [
        'title'             => Faker::fullName(),
        'description'       => nullable( Faker::sentence() ),
        'depth'             => $faker->numberBetween(1, 5),
        'logo'              => nullable( $faker->imageUrl(100, 100) ),
    ];
});