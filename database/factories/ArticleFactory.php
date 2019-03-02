<?php

use Faker\Generator as Faker;


function nullable ( $value )
{
    return [ null, $value ][ rand(0, 1) ];
}

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => $faker->text(255),
        'body'          => $faker->paragraph(),
        'image'         => $faker->imageUrl($width = 640, $height = 480),
        'reading_time'  => rand(1, 50)
    ];
});
