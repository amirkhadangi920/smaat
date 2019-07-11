<?php

namespace App\GraphQL\Query\Financial\ShippingMethod;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ShippingMethodsQuery extends BaseShippingMethodQuery
{
    use AllQuery;

    protected $has_more_args = true;
    
    public function get_args()
    {
        return [
            'is_active' => [
                'type' => Type::boolean()
            ],
            'has_logo' => [
                'type' => Type::boolean()
            ],
        ];
    }
}