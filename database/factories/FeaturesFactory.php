<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;

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

$colors = [
    [
        'name' => 'آبی',
        'code' => '#0d61e8',
    ], [
        'name' => 'قرمز',
        'code' => '#dd2a02',
    ], [
        'name' => 'سفید',
        'code' => '#ffffff',
    ], [
        'name' => 'سیاه',
        'code' => '#ffffff',
    ], [
        'name' => 'بنفش',
        'code' => '#7206cc',
    ], [
        'name' => 'زرد',
        'code' => '#fff200',
    ], [
        'name' => 'نارنجی',
        'code' => '#fcb000',
    ], [
        'name' => 'قهوه ای',
        'code' => '#fcb000',
    ], [
        'name' => 'سبز',
        'code' => '#fcb000',
    ], [
        'name' => 'خاکستری',
        'code' => '#5e5e5e',
    ], [
        'name' => 'صورتی',
        'code' => '#5e5e5e',
    ], [
        'name' => 'سرخ آبی',
        'code' => '#dd0658',
    ], [
        'name' => 'سرمه ای',
        'code' => '#00086b',
    ], [
        'name' => 'فیلی',
        'code' => '#c6c6c6',
    ], [
        'name' => 'طلایی',
        'code' => '#ffcc00',
    ],
];

$factory->define(App\Models\Feature\Brand::class, function () use($faker, &$brands)  {
    
    $brand = array_shift( $brands );

    return [
        'user_id'           => App\User::all()->random()->id,
        'name'              => $brand['name'],
        'description'       => nullable( $faker->sentence() ),
        'logo'              => nullable( image ( $brand['logo'] )),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Feature\Color::class, function () use($faker, &$colors) {

    $color = array_shift( $colors );

    return [
        'user_id'           => App\User::all()->random()->id,
        'name'              => $color['name'],
        'code'              => $color['code'],
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
