<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Size;
use App\Http\Resources\Feature\Size as SizeResource;
use App\ModelFilters\Feature\SizeFilter;

class SizeController extends FeatureBaseController
{
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
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = SizeFilter::class;
}
