<?php

use Faker\Factory;

$faker = Factory::create('fa_IR');

use App\Models\Financial\ShippingMethod;

$factory->define(App\Models\Financial\Order::class, function () use($faker) {
    $descriptions = $datetimes = [];
    if ( rand(0, 1) ) $descriptions['admin'] = Faker::sentence();
    if ( rand(0, 1) ) $descriptions['buyer'] = Faker::sentence();

    $auth_code = [ null, str_random(50) ][ $faker->boolean() ];

    if ( rand(0, 1) ) $datetimes['created']             = $faker->dateTime();
    if ( rand(0, 1) ) $datetimes['awaiting_payment']    = $faker->dateTime();
    if ( rand(0, 1) ) $datetimes['paied']               = $faker->dateTime();
    if ( rand(0, 1) ) $datetimes['sending']             = $faker->dateTime();
    if ( rand(0, 1) ) $datetimes['canceled']            = $faker->dateTime();
    if ( rand(0, 1) ) $datetimes['packaging']           = $faker->dateTime();


    return [
        'descriptions'      => nullable( $descriptions ),
        'type'              => $faker->numberBetween(0, 127),
        'destination'       => nullable( Faker::address() ),
        'postal_code'       => nullable( $faker->postcode ),
        'offer'             => $faker->numberBetween(0, 100000),
        'total'             => $faker->numberBetween(100000, 10000000),
        'payment_code'      => nullable( $faker->dateTime() ),
        'created_at'        => $faker->dateTime(),
        // 'payment_jalali'    => jdate( time() - ( rand(1, 1000) * rand(1, 1000) )),
        'auth_code'         => $auth_code,
        'payment_code'      => $auth_code ? str_random(30) : null,
        'datetimes'         => $datetimes,
        'shipping_method_id'=> nullable( factory(ShippingMethod::class)->create()->id ),
        'docs'              => nullable( $faker->words( rand(1, 10) ) ),
        'checkout'          => $faker->boolean(),
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
        'title'         => $faker->name(),
        'description'   => nullable( Faker::sentence() ) 
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