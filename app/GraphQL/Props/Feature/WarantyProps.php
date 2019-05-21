<?php

namespace App\GraphQL\Props\Feature;

use App\Models\Feature\Warranty;
use App\Http\Resources\Feature\Warranty as WarrantyResource;
use App\ModelFilters\Feature\WarrantyFilter;
use App\Http\Requests\v1\Feature\WarrantyRequest;
use App\Http\Resources\Feature\WarrantyCollection;

trait WarrantyProps
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
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = WarrantyCollection::class;

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
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = WarrantyRequest::class;
}