<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Opinion\Review::class, function () use($faker) {
    return [
        'ranks'         => [ null, function () use ( $faker ) {
            $ranks = [];
            for ($i = 0; $i < rand(1, 8); ++$i)
                $ranks[] = [ 'title' => $faker->word, 'value' => rand(0, 5) ];
            return $ranks;
        }][ $faker->boolean() ],
        'advantages'    => [ null, function () use ( $faker ) {
            $advantages = [];
            for ($i = 0; $i < rand(1, 5); ++$i)
                $advantages[] = Faker::sentence();
            return $advantages;
        }][ $faker->boolean() ],
        'disadvantages' => [ null, function () use ( $faker ) {
            $disadvantages = [];
            for ($i = 0; $i < rand(1, 5); ++$i)
                $disadvantages[] = Faker::sentence();
            return $disadvantages;
        }][ $faker->boolean() ],
        'message'       => Faker::sentence(),
        'is_accept'      => $faker->boolean()
        // 'created_at'    => $faker->unixTime()
    ];
});

$factory->define(App\Models\Opinion\Comment::class, function () use($faker) {
    return [
        'message'       => Faker::sentence(),
        'is_accept'      => $faker->boolean()
        // 'created_at'    => $faker->unixTime()
    ];
});

$factory->define(App\Models\Opinion\QuestionAndAnswer::class, function () use($faker) {
    return [
        'message'       => Faker::sentence(),
        'is_accept'     => $faker->boolean()
        // 'created_at'    => $faker->unixTime()
    ];
});