<?php

namespace App\GraphQL\Query\Financial\ShippingMethod;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Financial\ShippingMethodProps;

class BaseShippingMethodQuery extends MainQuery
{
    use ShippingMethodProps;
    
    protected $translatable = true;
}