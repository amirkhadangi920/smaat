<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Feature\Brand::class, function () use($faker, $brands)  {
    
    $selected = rand(0, count($brands) - 1);
    
    return [
        'logo'          => image ( $brands[$selected]['logo'] ),
        'name'          => $brands[$selected]['name'],
        'description'   => nullable( $faker->sentence() ),
        'logo'          => nullable( image ( $brands[$selected]['logo'] ))
    ];
});

$factory->define(App\Models\Feature\Color::class, function () use($faker) {
    return [
        'name'  => ['آبی', 'قرمز', 'سفید', 'سیاه', 'بنفش', 'زرد', 'نارنجی', 'قهوه ای', 'سبز', 'خاکستری', 'نارنجی', 'صورتی', 'سرخ آبی', 'صورتی چرک', 'فیلی', 'شیری',][rand(0,15 )],
        'code'  => $faker->hexcolor,
    ];
});

$factory->define(App\Models\Feature\Size::class, function () use($faker) {
    return [
        'name' => ['کوچک', 'متوسط', 'بزرگ', 'مدیوم', 'اسمال', 'لارج', 'ایکس لارج', 'دو ایکس لارج', ][ rand(0, 7)],
        'description'   => [ null, Faker::sentence(250) ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Feature\Unit::class, function () use($faker) {
    return [
        'title'         => ['مثقال', 'گرم', 'کیلو گرم', 'تن', 'کارتن', 'جعبه', 'یارد', 'متر', 'سانتی متر', ][rand(0, 8)],
        'description'   => [ null, Faker::sentence(250) ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Feature\Warranty::class, function () use($faker,$brands) {

    $selected = rand(0, count($brands) - 1);
    $warranties = [
        'طلایی',
        'آواژنگ',
        'مدیران',
        'دیجی کالا',
        'عودت وجه'
    ];

    return [
        'title'         => $warranties[$faker->numberBetween(0, 4)],
        'description'   => [ null, Faker::sentence(250) ][ $faker->boolean() ],
        'expire'        => $faker->numberBetween(1, 5) . ' ' . ['سال', 'ماه'][ $faker->boolean() ],
        'logo'          => nullable( image ( $brands[$selected]['logo'] )),
    ];
});
