<?php

namespace App\GraphQL\Props\Spec;

use App\Models\Spec\SpecDefault;
use App\Http\Requests\v1\Spec\SpecificationDefaultRequest;

trait SpecDefaultProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'spec_default';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SpecDefault::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SpecificationDefaultRequest::class;
}