<?php

namespace App\GraphQL\Query\Financial\OrderStatus;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class OrderStatusesQuery extends BaseOrderStatusQuery
{
    use AllQuery;

    protected $has_more_args = true;
    
    public function type()
    {
        return Type::listOf( \GraphQL::type( $this->type ) );
    }
    
    public function get_args()
    {
        return [
            'is_active' => [
                'type' => Type::boolean()
            ],
        ];
    }

    public function getPortionOfData($data, $args)
    {
        return $data->get();
    }
}