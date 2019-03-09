<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Color;
use App\Http\Resources\Feature\Color as ColorResource;

class ColorController extends FeatureBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'color';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Color::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ColorResource::class;
}