<?php

use Faker\Factory;
use Morilog\Jalali\Jalalian;
use App\Models\Financial\ShippingMethod;
use App\Models\Financial\OrderStatus;

$faker = Factory::create('fa_IR');


$factory->define(App\Models\Financial\Order::class, function () use($faker) {
    $descriptions = $datetimes = [];
    if ( rand(0, 1) ) $descriptions['admin'] = Faker::sentence();
    if ( rand(0, 1) ) $descriptions['buyer'] = Faker::sentence();

    $auth_code = [ null, str_random(50) ][ $faker->boolean() ];

    return [
        'user_id'           => App\User::all()->random()->id,
        'descriptions'      => nullable( $descriptions ),
        'type'              => $faker->numberBetween(0, 127),
        'destination'       => nullable( Faker::address() ),
        'postal_code'       => nullable( $faker->postcode ),
        'offer'             => $faker->numberBetween(0, 100000),
        'total'             => $faker->numberBetween(100000, 10000000),
        'created_at'        => $faker->dateTime(),
        // 'payment_jalali'    => jdate( time() - ( rand(1, 1000) * rand(1, 1000) )),
        'ref_id'            => nullable( $faker->numberBetween(1000000000000, 10000000000000) ),
        'trans_id'          => nullable( str_random(100) ),
        // 'datetimes'         => function() use($faker) {
        //     return [
        //         'status' => OrderStatus::all()->random()->id,
        //         'time' => $faker->dateTimeBetween('-2 years', 'now')
        //     ]
        // },
        'shipping_method_id'=> nullable( factory(ShippingMethod::class)->create()->id ),
        'docs'              => nullable( $faker->words( rand(1, 10) ) ),
        'checkout'          => $faker->boolean(),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days")
    ];
});

$factory->define(App\Models\Financial\OrderItem::class, function () use($faker) {
    return [
        'count'          => $faker->numberBetween(1, 5), 
        'price'          => $faker->numberBetween(0, 500000),
        'offer'          => $faker->numberBetween(0, 2000),
        'tax'            => $faker->numberBetween(0, 5000),
        'description'    => nullable( Faker::sentence())
    ];
});

$factory->define(App\Models\Financial\OrderStatus::class, function () use($faker) {
    return [
        'user_id'           => App\User::all()->random()->id,
        'title'             => [ 'در حال بررسی', 'بسته بندی ', 'چک کردن موجودی', 'تحویل بحش ارسال', 'در حال ارسال', ][rand( 0,  4)],
        'description'       => nullable( Faker::sentence() ),
        'color'             => $faker->hexcolor,
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days"),
        'is_active'         => $faker->boolean(80)
    ];
});

$factory->define(App\Models\Financial\OrderPoint::class, function () use($faker) {
    return [
        'value'         => $faker->numberBetween(0, 500000) 
    ];
});

$factory->define(App\Models\Financial\Coupen::class, function () use($faker) {
    return [
        'code'          => $faker->numberBetween(10000000, 99999999),
        'value'         => $faker->numberBetween(1000, 100000),
        'using_time'    => [ null, $faker->dateTime() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Financial\Account::class, function () use($faker, $brands) {

    $selected = rand(0, count($brands) - 1);
    return [
        'title'         => Faker::comapny(),
        'title_en'      => [ null, $faker->company ][ $faker->boolean() ],
        'description'   => [ null,  Faker::sentence ][ $faker->boolean() ],
        'type'          => [ 'کارت پستال', 'بانک', 'کارت بانکی' ][ rand(0, 2) ],
        // 'logo'          => nullable( image ( $brands[$selected]['logo'] )),
        'max_debt'      => $faker->numberBetween(0, 5000000),
    ];
});

$factory->define(App\Models\Financial\Transaction::class, function () use($faker) {
    return [
        'value'         => $faker->numberBetween(0, 5000000),
        'description'   => [ null, Faker::sentence ][ $faker->boolean() ],
        'type'          => [ $faker->boolean() ],
        'docs'          => [ null, function () use ( $faker ) {
            $docs = [];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $docs[] = [ 'title' => $faker->company, 'file' => $faker->words().$faker->fileExtension ];
            return $docs;
        }][ $faker->boolean() ],
    ];
});