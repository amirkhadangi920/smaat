<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$brands = [
    [
        'name' => 'ایسوس',
        'logo'  => '/tests/brand_logo/asus.png'
    ], [
        'name' => 'اپل',
        'logo'  => '/tests/brand_logo/apple.png'
    ], [
        'name' => 'هوآوی',
        'logo'  => '/tests/brand_logo/huawei.jpg'
    ], [
        'name' => 'بنز',
        'logo'  => '/tests/brand_logo/benz.png'
    ], [
        'name' => 'بی ام وی',
        'logo'  => '/tests/brand_logo/bmw.jpg'
    ], [
        'name' => 'لند روور',
        'logo'  => '/tests/brand_logo/land_rover.jpg'
    ], [
        'name' => 'بوگاتی',
        'logo'  => '/tests/brand_logo/bugatti.png'
    ], [
        'name' => 'فراری',
        'logo'  => '/tests/brand_logo/ferari.jpg'
    ], [
        'name' => 'فورد',
        'logo'  => '/tests/brand_logo/ford.png'
    ], [
        'name' => 'ماکسیما',
        'logo'  => '/tests/brand_logo/maxima.png'
    ], [
        'name' => 'شیائومی',
        'logo'  => '/tests/brand_logo/mi.png'
    ], [
        'name' => 'سامسونگ',
        'logo'  => '/tests/brand_logo/samsung.png'
    ], [
        'name' => 'سونی اریکسن',
        'logo'  => '/tests/brand_logo/Sony_Ericsson.png'
    ], [
        'name' => 'سونی',
        'logo'  => '/tests/brand_logo/Sony.png'
    ], [
        'name' => 'تسلا',
        'logo'  => '/tests/brand_logo/tesla.png'
    ],

];


$factory->define(App\Models\Discount\Discount::class, function () use ($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    
    return [
        'user_id'       => App\User::all()->random()->id,
        'title'         => $faker->name(),
        'description'   => nullable( Faker::sentence(250) ),
        // 'logo'          => nullable( image ( $brands[$selected]['logo'] )),
        'type'          => nullable( $faker->numberBetween(0 , 100)),
        'status'        => $faker->numberBetween(0 , 100),
        'started_at'    => $faker->dateTime(),
        'expired_at'    => $faker->dateTime(),
        'is_active'     => $faker->boolean(80)
    ];
});


$factory->define(App\Models\Discount\DiscountItem::class, function () use ($faker , $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'offer'         => $faker->numberBetween(1000 , 50000),
        'quantity'      => nullable( $faker->numberBetween(20000 , 50000)),
        'sold_count'    => $faker->numberBetween(1000 , 500000),
    ];
});
