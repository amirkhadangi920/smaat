<?php

namespace App\GraphQL\Query\Financial\OrderStatus;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Financial\OrderStatusProps;

class BaseOrderStatusQuery extends MainQuery
{
    use OrderStatusProps;

    protected $translatable = true;
}