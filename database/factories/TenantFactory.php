<?php

use Faker\Factory;
use App\User;

$faker = Factory::create('fa_IR');

$factory->define(App\Models\Tenant::class, function () use ($faker) {
    return [
        'user_id'       => factory(User::class)->create()->id,
        'title'         => $faker->name(),
        'description'   => nullable( Faker::sentence(250) ),
    ];
});

$factory->define(App\Models\Hostname::class, function () use ($faker) {
    return [
        'domain'   => $faker->domainName,
    ];
});
