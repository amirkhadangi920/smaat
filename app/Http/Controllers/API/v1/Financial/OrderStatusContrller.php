<?php

namespace App\Http\Controllers\API\v1\Financial;

use App\Models\Financial\OrderStatus;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\OrderStatus as OrderStatusResource;
use App\ModelFilters\Financial\OrderStatusFilter;
use App\Http\Requests\v1\Order\OrderStatusRequest;
use App\Http\Resources\Financial\OrderStatusCollection;

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
     * Get the request from url and pass it to storeData method
     * to create a new order_status in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(OrderStatusRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $order_status in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(OrderStatusRequest $request, OrderStatus $order_status)
    {
        return $this->updateWithRequest($request, $order_status);
    }

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::filter( request()->all(), $this->filter )->get();
    }
}
