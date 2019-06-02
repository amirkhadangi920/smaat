<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Financial\Order;

class OrderType extends BaseType
{
    public $incrementing = false;

    protected $attributes = [
        'name' => 'OrderType',
        'description' => 'A type',
        'model' => Order::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'destination' => [
                'type' => Type::string(),
                'privacy' => function() {
                    return $this->checkPermission("see-address-order");
                }
            ],
            'phone_number' => [
                'type' => Type::string(),
                'privacy' => function() {
                    return $this->checkPermission("see-phone-number-order");
                }
            ],
            'coordinates' => [
                'type' => \GraphQL::type('coordinate'),
                'privacy' => function() {
                    return $this->checkPermission("see-address-order");
                },
                'is_relation' => false
            ],
            'postal_code' => [
                'type' => Type::string(),
                'privacy' => function() {
                    return $this->checkPermission("see-address-order");
                }
            ],
            'offer' => [
                'type' => Type::int(),
                'privacy' => function() {
                    return $this->checkPermission("see-details-order");
                }
            ],
            'total' => [
                'type' => Type::int(),
                'privacy' => function() {
                    return $this->checkPermission("see-details-order");
                }
            ],
            'shipping_cost' => [
                'type' => Type::int(),
                'privacy' => function() {
                    return $this->checkPermission("see-details-order");
                }
            ],
            'paid_at' => [
                'type' => $this->checkPermission("see-details-order") ? Type::string() : Type::boolean(),
            ],
            'user' => [
                'type' => \GraphQL::type('user')
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
                'privacy' => function() {
                    return $this->checkPermission("see-address-order");
                }
            ],
            'items' => [
                'type' => Type::listOf( \GraphQL::type('order_item') ),
                'privacy' => function() {
                    return $this->checkPermission("see-items-order");
                }
            ],
            'audits' => $this->audits('order'),
        ];
    }
}