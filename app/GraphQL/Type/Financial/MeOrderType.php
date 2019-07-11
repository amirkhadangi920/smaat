<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Financial\Order;

class MeOrderType extends BaseType
{
    public $incrementing = false;

    protected $attributes = [
        'name' => 'MeOrderType',
        'description' => 'A type',
        'model' => Order::class
    ];

    public function get_fields()
    {
        return [
            'destination' => [
                'type' => Type::string(),
            ],
            'phone_number' => [
                'type' => Type::string(),
            ],
            'coordinates' => [
                'type' => \GraphQL::type('coordinate'),
                'is_relation' => false
            ],
            'postal_code' => [
                'type' => Type::string(),
            ],
            'offer' => [
                'type' => Type::int(),
            ],
            'total' => [
                'type' => Type::int(),
            ],
            'shipping_cost' => [
                'type' => Type::int(),
            ],
            'paid_at' => [
                'type' => Type::string(),
            ],
            'order_status' => [
                'type' => \GraphQL::type('order_status')
            ],
            'status_changes' => [
                'type' => Type::listOf( \GraphQL::type('order_status') )
            ],
            'shipping_method' => [
                'type' => \GraphQL::type('shipping_method')
            ],
            'city' => [
                'type' => \GraphQL::type('city'),
            ],
            'items' => [
                'type' => Type::listOf( \GraphQL::type('me_order_item') ),
            ],
        ];
    }
}