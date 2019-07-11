<?php

namespace App\GraphQL\Props\Spec;

use App\Models\Spec\Spec;
use App\Http\Resources\Spec\Spec as SpecResource;
use App\ModelFilters\Spec\SpecFilter;
use App\Http\Requests\v1\Spec\SpecificationRequest;
use App\Http\Resources\Spec\SpecCollection;

trait SpecProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'spec';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Spec::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = SpecCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = SpecFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SpecificationRequest::class;
}