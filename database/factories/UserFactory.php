<?php

use Faker\Factory as FakerEng;
use Ybazli\Faker\Facades\Faker;

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

$factory->define(App\User::class, function ($faker) {
    $faker = FakerEng::create('fa_IR');
    
    return [
        'first_name'        => [ null, $faker->firstName() ][ $faker->boolean() ],
        'last_name'         => [ null, $faker->lastName() ][ $faker->boolean() ],
        'phones'            => [ null, function () use ( $faker ) {
            $phones = [];
            $titles = [ 'home', 'mobile', 'work', 'special' ];
            for ($i = 0; $i < rand(0, 5); ++$i)
                $phones[] = [ 'type' => $titles[ rand(0, 3) ], 'value' => $faker->phoneNumber ];
            return $phones;
        }][ $faker->boolean() ],
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'avatar'            => [ null, $faker->imageUrl(50, 50) ][ $faker->boolean() ],
        'address'           => [ null, $faker->address ][ $faker->boolean() ],
        'postal_code'       => [ null, $faker->postcode ][ $faker->boolean() ],
        'national_code'     => [ null, '0'.$faker->numberBetween(910000000, 959999999) ][ $faker->boolean() ],
        'type'              => 0,
        'remember_token'    => str_random(10),
    ];
});
