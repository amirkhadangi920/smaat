<?php

namespace App\GraphQL\Props\Feature;

use App\Models\Feature\Unit;
use App\Http\Resources\Feature\Unit as UnitResource;
use App\ModelFilters\Feature\UnitFilter;
use App\Http\Requests\v1\Feature\UnitRequest;
use App\Http\Resources\Feature\UnitCollection;

trait UnitProps
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
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = UnitCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = UnitFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = UnitRequest::class;
}