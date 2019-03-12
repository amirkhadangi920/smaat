<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Unit;
use App\Http\Resources\Feature\Unit as UnitResource;
use App\ModelFilters\Feature\UnitFilter;

class UnitController extends FeatureBaseController
{
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

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = UnitFilter::class;
}
