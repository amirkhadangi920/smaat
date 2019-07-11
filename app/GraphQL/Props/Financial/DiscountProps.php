<?php

namespace App\GraphQL\Props\Financial;

use App\Models\Discount\Discount;
use App\Http\Resources\Financial\Discount as DiscountResource;
use App\Http\Requests\v1\Order\DiscountRequest;
use App\ModelFilters\Financial\DiscountFilter;
use App\Http\Resources\Financial\DiscountCollection;

trait DiscountProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'discount';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Discount::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = DiscountResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = DiscountCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = DiscountFilter::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = DiscountRequest::class;
}