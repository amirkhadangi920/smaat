<?php

namespace App\GraphQL\Query\Financial\OrderStatus;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class OrderStatusesQuery extends BaseOrderStatusQuery
{
    use AllQuery;

    protected $has_more_args = true;
    
    public function get_args()
    {
        return [
            'is_active' => [
                'type' => Type::boolean()
            ],
        ];
    }
}