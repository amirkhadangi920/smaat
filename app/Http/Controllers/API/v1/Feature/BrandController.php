<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Brand;
use App\Http\Resources\Feature\Brand as BrandResource;
use App\Helpers\SluggableController;

class BrandController extends FeatureBaseController
{
    use SluggableController;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'brand';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Brand::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = BrandResource::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';
}
