<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Feature\Brand::class, function () use($faker, $brands)  {
    
    $selected = rand(0, count($brands) - 1);
    return [
        'user_id'           => App\User::all()->random()->id,
        'logo'              => image( $brands[$selected]['logo'] ),
        'name'              => $brands[$selected]['name'],
        'description'       => nullable( $faker->sentence() ),
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Feature\Color::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'name'              => [
            'آبی', 'قرمز', 'سفید', 'سیاه', 'بنفش', 'زرد',
            'نارنجی', 'قهوه ای', 'سبز', 'خاکستری', 'نارنجی',
            'صورتی', 'سرخ آبی', 'صورتی چرک', 'فیلی', 'شیری',
        ][rand(0,15 )],
        'code'              => $faker->hexcolor,
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Feature\Size::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'name'              => [
            'کوچک', 'متوسط', 'بزرگ', 'مدیوم', 'اسمال', 'لارج', 'ایکس لارج', 'دو ایکس لارج'
        ][ rand(0, 7)],
        'description'       => nullable( Faker::sentence(250) ),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Feature\Unit::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => [
            'مثقال', 'گرم', 'کیلو گرم', 'تن', 'کارتن', 'جعبه', 'یارد', 'متر', 'سانتی متر'
        ][rand(0, 8)],
        'description'       => nullable( Faker::sentence(250) ),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
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
        'user_id'           => App\User::all()->random()->id,
        'title'             => $warranties[$faker->numberBetween(0, 4)],
        'description'       => nullable( Faker::sentence(250) ),
        'expire'            => $faker->numberBetween(1, 5) . ' ' . ['سال', 'ماه'][ $faker->boolean() ],
        'logo'              => nullable( image ( $brands[$selected]['logo'] )),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});
