<?php

namespace App\GraphQL\Props\Place;

use App\Models\Places\City;

trait CityProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'city';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = City::class;
}