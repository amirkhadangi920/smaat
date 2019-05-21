<?php

namespace App\GraphQL\Query\Financial\ShippingMethod;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ShippingMethodsQuery extends BaseShippingMethodQuery
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