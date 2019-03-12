<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Product\Product::class, function () use($faker) {
    return [
        'name'              => $faker->company,
        'second_name'       => $faker->company,
        'code'              => $faker->ean8,
        'description'       => Faker::sentence(),
        'note'              => Faker::sentence(),
        'aparat_video'      => 'SEQ2V',
        'status'            => rand(0,1),
        'review'            => Faker::paragraph(),
        'keywords'          => $faker->words( rand(1, 10) ),
        'advantages'        => $faker->sentences( rand(1, 10) ),
        'disadvantages'     => $faker->sentences( rand(1, 10) ),
        'label'             => $faker->numberBetween(0, 4),
        'views_count'       => $faker->numberBetween(0, 10000),
        'photos'            => [ null, function () use ( $faker ) {
            $photos = [];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $photos[] = $faker->imageUrl(480, 320);
            return $photos;
        }][ $faker->boolean() ], 
    ];
});

$factory->define(App\Models\Product\Variation::class, function (FakerEng $faker) {
    
    $price = $faker->numberBetween(1000, 20000000);
    return [
        'purchase_price'        => $price,
        'sales_price'           => $faker->numberBetween(1000, $price),
        'inventory'             => [ null, $faker->numberBetween(0, 100) ][ $faker->boolean() ],
        'sending_time'          => $faker->numberBetween(1, 10),
        'status'                => $faker->boolean(),
        'old_purchase_prices'   => [ null, function () use ( $faker ) {
            $prices = [];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $prices[] = [ 'price' => $faker->imageUrl(480, 320), 'datetime' => $faker->dateTimeBetween('-2 years', 'now') ];
            return $prices;
        }][ $faker->boolean() ],
        'old_sales_prices'      => [ null, function () use ( $faker ) {
            $prices = [];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $prices[] = [ 'price' => $faker->imageUrl(480, 320), 'datetime' => $faker->dateTimeBetween('-2 years', 'now') ];
            return $prices;
        }][ $faker->boolean() ],
    ];
});