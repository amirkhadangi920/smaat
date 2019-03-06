<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Unit;
use App\Http\Controllers\Controller;
use App\Http\Resources\Feature\Unit as UnitResource;
use App\Traits\Controllers\FeatureControllers;

class UnitController extends Controller
{
    use FeatureControllers;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'unit';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Unit::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = UnitResource::class;
}
