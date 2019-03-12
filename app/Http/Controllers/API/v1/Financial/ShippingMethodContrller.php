<?php

namespace App\Http\Controllers\API\v1\Financial;

use App\Models\Financial\ShippingMethod;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\ShippingMethod as ShippingMethodResource;
use App\ModelFilters\Financial\ShippingMethodFilter;
use App\Http\Requests\v1\Order\ShippingMethodRequest;

class ShippingMethodContrller extends MainController
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
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ShippingMethodFilter::class;
    
    /**
     * Get the request from url and pass it to storeData method
     * to create a new shipping_method in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(ShippingMethodRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $shipping_method in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(ShippingMethodRequest $request, ShippingMethod $shipping_method)
    {
        return $this->updateWithRequest($request, $shipping_method);
    }
}
