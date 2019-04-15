<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

$faker = Factory::create('fa_IR');

function nullable ( $value )
{
    return [ null, $value ][ rand(0, 1) ];
}

function image ($file)
{
    return [
        'big'       => $file,
        'medium'    => $file,
        'small'     => $file,
        'tiny'      => $file,
    ];
}


$factory->define(App\Models\Article::class, function () use ($faker) {
    return [
        'title'         => $faker->name(),
        'description'   => nullable( Faker::sentence(250) ),
        'body'          => Faker::paragraph(),
        'image'         => image( $faker->imageUrl($width = 640, $height = 480) ),
        'reading_time'  => rand(1, 50),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days")
    ];
});
