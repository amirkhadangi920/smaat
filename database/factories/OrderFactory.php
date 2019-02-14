<?php

use Faker\Generator as FakerEng;

$factory->define(App\Models\Order\Order::class, function (FakerEng $faker) {
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
        'descriptions'      => [ null, $descriptions ][ $faker->boolean() ],
        'destination'       => [ null, Faker::address() ][ $faker->boolean() ],
        'postal_code'       => [ null, $faker->postcode ][ $faker->boolean() ],
        'offer'             => $faker->numberBetween(0, 100000),
        'total'             => $faker->numberBetween(100000, 10000000),
        'payment'           => [ null, $faker->dateTime() ][ $faker->boolean() ],
        'created_at'        => $faker->dateTime(),
        'payment_jalali'    => jdate( time() - ( rand(1, 1000) * rand(1, 1000) )),
        'auth_code'         => $auth_code,
        'payment_code'      => $auth_code ? str_random(30) : null,
        'datetimes'         => $datetimes,
        'shipping'          => [ null, [
            'cost' => $faker->numberBetween(0, 20000),
            'type' => [ 'model1', 'model2', 'model3', 'model4' ][ rand(0, 3) ]
        ]][ $faker->boolean() ],
        'status'            => [
            'created', 'awaiting_payment', 'paied', 'sending', 'sended', 'canceled', 'packaging'
        ][ rand(0, 6) ],
    ];
});

$factory->define(App\Models\Order\OrderItem::class, function (FakerEng $faker) {
    return [
       'count' => $faker->numberBetween(1, 5), 
    ];
});

$factory->define(App\Models\Order\DiscountCode::class, function (FakerEng $faker) {
    return [
        'code'          => $faker->numberBetween(10000000, 99999999),
        'value'         => $faker->numberBetween(1000, 100000),
        'using_time'    => [ null, $faker->dateTime() ][ $faker->boolean() ]
    ];
});