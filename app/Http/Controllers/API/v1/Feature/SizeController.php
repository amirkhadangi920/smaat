<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Size;
use App\Http\Controllers\Controller;
use App\Http\Resources\Feature\Size as SizeResource;
use App\Traits\Controllers\FeatureControllers;

class SizeController extends Controller
{
    use FeatureControllers;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'size';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Size::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SizeResource::class;
}
