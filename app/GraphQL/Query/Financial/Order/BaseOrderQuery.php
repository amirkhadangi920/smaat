<?php

namespace App\GraphQL\Query\Financial\Order;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Financial\OrderProps;

class BaseOrderQuery extends MainQuery
{
    use OrderProps;

    protected $incrementing = false;

    protected $acceptable = false;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-order');
    }
}