<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Warranty;
use App\Http\Resources\Feature\Warranty as WarrantyResource;
use App\ModelFilters\Feature\WarrantyFilter;

class WarrantyController extends FeatureBaseController
{
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
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = WarrantyFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';
}
