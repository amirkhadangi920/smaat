<?php

namespace App\GraphQL\Props\Place;

use App\Models\Places\Province;

trait ProvinceProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'province';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Province::class;
}