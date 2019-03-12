<?php

namespace App\Http\Controllers\API\v1\Financial;

use App\Models\Financial\OrderStatus;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\OrderStatus as OrderStatusResource;
use App\ModelFilters\Financial\OrderStatusFilter;

class OrderStatusContrller extends MainController
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
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = OrderStatusFilter::class;
}
