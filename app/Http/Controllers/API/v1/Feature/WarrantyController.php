<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Warranty;
use App\Http\Controllers\Controller;
use App\Http\Resources\Feature\Warranty as WarrantyResource;
use App\Traits\Controllers\FeatureControllers;

class WarrantyController extends Controller
{
    use FeatureControllers;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'warranty';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Warranty::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = WarrantyResource::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';
}
