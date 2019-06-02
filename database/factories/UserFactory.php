<?php


use Faker\Factory;

$faker = Factory::create('fa_IR');

use Ybazli\Faker\Facades\Faker;
use Morilog\Jalali\Jalalian;

$avatars = [
    [
        'img' => '/tests/avatars/man_1.png'  
    ], [
        'img' => '/tests/avatars/man_2.jpg'
    ], [
        'img' => '/tests/avatars/women_1.png'
    ], [
        'img' => '/tests/avatars/women_2.jpg'
    ]
];

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function () use($faker , $avatars) {
    
    $select = rand( 0, count($avatars)-1 );

    return [
        'first_name'        => nullable( $faker->firstName() ),
        'last_name'         => nullable( $faker->lastName() ),
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'avatar'            => nullable( image($avatars[$select]['img']) ),
        // 'address'           => nullable( $faker->address ),
        // 'postal_code'       => nullable( $faker->postcode ),
        'national_code'     => nullable( '0'.$faker->numberBetween(910000000, 959999999) ),
        // 'type'              => 0,
        'remember_token'    => str_random(10),
        'last_purchase'     => nullable( $faker->dateTimeBetween('-3 years', 'now') ),
        'purchase_counts'   => rand(0, 20),
        'total_payments'    => rand(0, 50000000),
        // 'phones'            => nullable(
        //     function () use ($faker) {
        //         $phones = [];
        //         $titles = [ 'home', 'mobile', 'work', 'special' ];
        //         for ($i = 0; $i < rand(0, 5); ++$i)
        //             $phones[] = [ 'type' => $titles[ rand(0, 3) ], 'value' => $faker->phoneNumber ];
        //         return $phones;
        //     }
        // ),
        // 'social_links'      => nullable(
        //     function () use ( $faker ) {
        //         $social_links = [];
        //         $titles = [ 'telegram', 'facebook', 'instagram', 'twitter' ];
        //         for ($i = 0; $i < rand(0, 5); ++$i)
        //             $social_links[] = [ 'type' => $titles[ rand(0, 3) ], 'value' => $faker->userName ];
        //         return $social_links;
        //     }
        // ),
        'jalali_created_at' => Jalalian::forge("now - {$faker->numberBetween(2, 360)} days")
    ];
});