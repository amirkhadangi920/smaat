<?php

namespace App\Http\Controllers\API\v1\Financial;

use App\Models\Financial\ShippingMethod;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\ShippingMethod as ShippingMethodResource;
use App\ModelFilters\Financial\ShippingMethodFilter;

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
}
