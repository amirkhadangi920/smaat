<?php

namespace App\GraphQL\Props\Place;

use App\Models\Places\Country;

trait CountryProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'country';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Country::class;
}