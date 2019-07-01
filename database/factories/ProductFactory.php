<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;
use App\Models\Feature\Brand;
use App\Models\Feature\Unit;
use App\Models\Feature\Color;
use App\Models\Feature\Size;
use App\Models\Feature\Warranty;

$faker = Factory::create('fa_IR');

$products = [
    [
        'logo'  => '/tests/product_img/0.jpg'
    ], [
        'logo'  => '/tests/product_img/1.jpg'
    ], [
        'logo'  => '/tests/product_img/2.jpg'
    ], [
        'logo'  => '/tests/product_img/3.jpg'
    ], [
        'logo'  => '/tests/product_img/4.jpg'
    ], [
        'logo'  => '/tests/product_img/5.jpg'
    ], [
        'logo'  => '/tests/product_img/6.jpg'
    ], [
        'logo'  => '/tests/product_img/7.jpg'
    ], [
        'logo'  => '/tests/product_img/8.jpg'
    ], [
        'logo'  => '/tests/product_img/9.jpg'
    ], [
        'logo'  => '/tests/product_img/10.jpg'
    ], [
        'logo'  => '/tests/product_img/11.jpg'
    ], [
        'logo'  => '/tests/product_img/12.jpg'
    ], [
        'logo'  => '/tests/product_img/13.png'
    ], [
        'logo'  => '/tests/product_img/14.jpg'
    ],

];

$factory->define(App\Models\Product\Product::class, function () use($faker, $products) {
    
    $selected = rand(0, count($products) - 1);
    return [
        'user_id'           => App\User::all()->random()->id,
        'brand_id'          => Brand::all()->random()->id,
        'unit_id'           => Unit::all()->random()->id,
        'name'              => $faker->company,
        'second_name'       => $faker->words(),
        'code'              => $faker->ean8,
        'description'       => Faker::sentence(),
        'note'              => Faker::sentence(),
        'aparat_video'      => 'SEQ2V',
        'short_review'      => Faker::paragraph(),
        'expert_review'     => Faker::paragraph(),
        'advantages'        => $faker->sentences( rand(1, 10) ),
        'disadvantages'     => $faker->sentences( rand(1, 10) ),
        'views_count'       => $faker->numberBetween(0, 10000),
        // 'photos'            => [ null, function () use($products, $selected) {
        //     $photos = [];
        //     for ($i = 0; $i < rand(0, 5); ++$i)
        //         $photos[] = image( $products[$selected]['logo'] );
        //     return $photos;
        // }][ $faker->boolean() ],
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Product\Variation::class, function () use($faker) {
    
    $price = $faker->numberBetween(1000, 20000000);
    return [
        'user_id'               => App\User::all()->random()->id,
        'color_id'              => Color::all()->random()->id,
        'size_id'               => Size::all()->random()->id,
        'warranty_id'           => Warranty::all()->random()->id,
        'purchase_price'        => $price,
        'sales_price'           => $faker->numberBetween(1000, $price),
        'inventory'             => [ null, $faker->numberBetween(0, 100) ][ $faker->boolean() ],
        'sending_time'          => $faker->numberBetween(1, 10),
        'is_active'             => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Product\Label::class, function () use($faker) {

    $labels = [
        'توقف تولید',
        'به زودی',
        'عدم فروش',
        'عدم موجودی',
        'تخفیف ویژه',
        'از رده خارج'
    ];

    return [
        'title'             => $labels[ rand(0, count($labels) - 1) ],
        'description'       => Faker::sentence(),
        'color'             => $faker->hexColor,
        'is_active'         => $faker->boolean(80)
    ];
});