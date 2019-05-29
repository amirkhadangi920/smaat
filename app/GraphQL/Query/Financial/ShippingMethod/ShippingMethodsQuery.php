<?php

namespace App\GraphQL\Query\Financial\ShippingMethod;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ShippingMethodsQuery extends BaseShippingMethodQuery
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
            'has_logo' => [
                'type' => Type::boolean()
            ],
        ];
    }

    public function getPortionOfData($data, $args)
    {
        return $data->get();
    }
}