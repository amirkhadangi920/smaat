<?php

namespace App\GraphQL\Query\Financial\Order;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class OrdersQuery extends BaseOrderQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'code' => [
                'type' => Type::string()
            ],
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'has_discount' => [
                'type' => Type::boolean()
            ],
            'is_paid' => [
                'type' => Type::boolean()
            ],
            'buyers' => [
                'type' => Type::listOf( Type::string() )
            ],
            'statuses' => [
                'type' => Type::listOf( Type::int() )
            ],
            'shipping_methods' => [
                'type' => Type::listOf( Type::int() )
            ],
            'cities' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}