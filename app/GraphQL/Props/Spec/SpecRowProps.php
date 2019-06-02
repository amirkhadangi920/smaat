<?php

namespace App\GraphQL\Props\Spec;

use App\Models\Spec\SpecRow;
use App\Http\Resources\Spec\SpecRow as SpecRowResource;
use App\Http\Requests\v1\Spec\SpecificationRowRequest;

trait SpecRowProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'spec_row';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SpecRow::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecRowResource::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SpecificationRowRequest::class;
}