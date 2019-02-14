<?php

use Faker\Generator as FakerEng;

$factory->define(App\Models\Group\Category::class, function (FakerEng $faker) {
    return [
        'title'             => Faker::fullName(),
        'description'       => [ null, Faker::sentence() ][ $faker->boolean() ],
        'depth'             => $faker->numberBetween(1, 5),
        'logo'              => [ null, $faker->imageUrl(100, 100) ][ $faker->boolean() ],
        'scoring_feilds'    => [ null, function () use ( $faker ) {
            $feilds = [];
            for ($i = 0; $i < rand(1, 8); ++$i)
                $feilds[] = $faker->sentence();
            return $feilds;
        }][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Group\Subject::class, function (FakerEng $faker) {
    return [
        'title'             => Faker::fullName(),
        'description'       => [ null, Faker::sentence() ][ $faker->boolean() ],
        'depth'             => $faker->numberBetween(1, 5),
        'logo'              => [ null, $faker->imageUrl(100, 100) ][ $faker->boolean() ],
    ];
});
