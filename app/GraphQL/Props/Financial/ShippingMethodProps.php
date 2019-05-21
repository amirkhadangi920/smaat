<?php

namespace App\GraphQL\Props\Financial;

use App\Models\Financial\ShippingMethod;
use App\Http\Resources\Financial\ShippingMethod as ShippingMethodResource;
use App\ModelFilters\Financial\ShippingMethodFilter;
use App\Http\Requests\v1\Order\ShippingMethodRequest;
use App\Http\Resources\Financial\ShippingMethodCollection;

trait ShippingMethodProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'shipping_method';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = ShippingMethod::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ShippingMethodResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = ShippingMethodCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ShippingMethodFilter::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = ShippingMethodRequest::class;
}