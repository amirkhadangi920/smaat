<?php

namespace App\GraphQL\Props\Spec;

use App\Models\Spec\SpecHeader;
use App\Http\Resources\Spec\SpecHeader as SpecHeaderResource;
use App\Http\Requests\v1\Spec\SpecificationHeaderRequest;

trait SpecHeaderProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'spec_header';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SpecHeader::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'spec:id,title,description'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecHeaderResource::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SpecificationHeaderRequest::class;
}