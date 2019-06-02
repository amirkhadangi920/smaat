<?php

namespace App\GraphQL\Props\Financial;

use App\Http\Resources\Financial\Order as OrderResource;
use App\Models\Financial\Order;
use App\ModelFilters\Financial\OrderFilter;
use App\Http\Requests\v1\Order\OrderRequest;
use App\Http\Resources\Financial\OrderCollection;

trait OrderProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'order';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Order::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = OrderResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = OrderCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = OrderFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = OrderRequest::class;
}