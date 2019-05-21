<?php

namespace App\GraphQL\Query\Financial\OrderStatus;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class OrderStatusesQuery extends BaseOrderStatusQuery
{
    use AllQuery;

    public function type()
    {
        return Type::listOf( \GraphQL::type( $this->type ) );
    }

    public function getPortionOfData($data, $args)
    {
        return $data->get();
    }
}