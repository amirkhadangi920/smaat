<?php

use Faker\Generator as FakerEng;
use App\Models\Financial\ShippingMethod;

$factory->define(App\Models\Financial\Order::class, function (FakerEng $faker) {
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
        'type'              => $faker->numberBetween(0, 100),
        'destination'       => nullable( Faker::address() ),
        'postal_code'       => nullable( $faker->postcode ),
        'offer'             => $faker->numberBetween(0, 100000),
        'total'             => $faker->numberBetween(100000, 10000000),
        'payment_code'           => nullable( $faker->dateTime() ),
        'created_at'        => $faker->dateTime(),
        // 'payment_jalali'    => jdate( time() - ( rand(1, 1000) * rand(1, 1000) )),
        'auth_code'         => $auth_code,
        'payment_code'      => $auth_code ? str_random(30) : null,
        'datetimes'         => $datetimes,
        'shipping_method_id'=> nullable( factory(ShippingMethod::class)->create()->id ),
        // 'status'            => [
        //     'created', 'awaiting_payment', 'paied', 'sending', 'sended', 'canceled', 'packaging'
        // ][ rand(0, 6) ],
    ];
});

$factory->define(App\Models\Financial\OrderItem::class, function (FakerEng $faker) {
    return [
       'count'          => $faker->numberBetween(1, 5), 
       'price'          => $faker->numberBetween(0, 500000),
       'offer'          => $faker->numberBetween(0, 2000),
       'tax'            => $faker->numberBetween(0, 5000),
       'description'    => $faker->text(255)
    ];
});

$factory->define(App\Models\Financial\OrderStatus::class, function (FakerEng $faker) {
    return [
        'title'         => $faker->name(),
        'description'   => $faker->sentence(), 
    ];
});

$factory->define(App\Models\Financial\OrderPoint::class, function (FakerEng $faker) {
    return [
        'value'         => $faker->numberBetween(0, 500000) 
    ];
});

$factory->define(App\Models\Financial\Coupen::class, function (FakerEng $faker) {
    return [
        'code'          => $faker->numberBetween(10000000, 99999999),
        'value'         => $faker->numberBetween(1000, 100000),
        'using_time'    => [ null, $faker->dateTime() ][ $faker->boolean() ]
    ];
});

$factory->define(App\Models\Financial\Account::class, function (FakerEng $faker) {
    return [
        'title'         => Faker::comapny(),
        'title_en'      => [ null, $faker->company ][ $faker->boolean() ],
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ],
        'type'          => [ 'personal', 'bank', 'cart' ][ rand(0, 2) ],
        'logo'          => [ null, $faker->imageUrl() ][ $faker->boolean() ],
        'max_debt'      => $faker->numberBetween(0, 5000000),
    ];
});

$factory->define(App\Models\Financial\Transaction::class, function (FakerEng $faker) {
    return [
        'value'         => $faker->numberBetween(0, 5000000),
        'description'   => [ null, $faker->sentence() ][ $faker->boolean() ],
        'type'          => [ $faker->boolean() ],
        'docs'          => [ null, function () use ( $faker ) {
            $docs = [];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $docs[] = [ 'title' => $faker->company, 'file' => $faker->words().$faker->fileExtension ];
            return $docs;
        }][ $faker->boolean() ],
    ];
});