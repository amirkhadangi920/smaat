<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Feature\Brand::class, function (Faker $faker) {
    return [
        'logo'          => [ null, $faker->imageUrl() ][ $faker->boolean() ],
        'name'          => $faker->name(),
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Feature\Color::class, function (Faker $faker) {
    return [
        'name'  => $faker->colorName,
        'code'  => $faker->hexcolor,
    ];
});

$factory->define(App\Models\Feature\Size::class, function (Faker $faker) {
    return [
        'name' => $faker->name()
    ];
});

$factory->define(App\Models\Feature\Unit::class, function (Faker $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => $faker->sentence(),
    ];
});

$factory->define(App\Models\Feature\Warranty::class, function (Faker $faker) {
    $warranties = [
        'طلایی',
        'آواژنگ',
        'مدیران',
        'دیجی کالا',
        'عودت وجه'
    ];

    return [
        'title'         => $warranties[$faker->numberBetween(0, 4)],
        'description'   => $faker->sentence(),
        'expire'        => $faker->numberBetween(1, 5) . ' ' . ['سال', 'ماه'][ $faker->boolean() ],
        'logo'          => $faker->imageUrl(100 , 100)
    ];
});
