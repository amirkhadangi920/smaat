<?php

namespace App\GraphQL\Props\Financial;

use App\Models\Financial\OrderStatus;
use App\Http\Resources\Financial\OrderStatus as OrderStatusResource;
use App\ModelFilters\Financial\OrderStatusFilter;
use App\Http\Requests\v1\Order\OrderStatusRequest;
use App\Http\Resources\Financial\OrderStatusCollection;

trait OrderStatusProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'order_status';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = OrderStatus::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = OrderStatusResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = OrderStatusCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = OrderStatusFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = OrderStatusRequest::class;
}