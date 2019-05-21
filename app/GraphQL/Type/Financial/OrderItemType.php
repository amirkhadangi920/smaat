<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Financial\OrderItem;

class OrderItemType extends BaseType
{
    public $incrementing = false;
    
    protected $attributes = [
        'name' => 'OrderItemType',
        'description' => 'A type',
        'model' => OrderItem::class
    ];

    public function get_fields()
    {
        return [
            'price' => $this->getOrderItemField(),
            'offer' => $this->getOrderItemField(),
            'count' => $this->getOrderItemField(),
            'variation' => $this->relationItemField('variation', 'is_active', 'read-product')
        ];
    }

    public function getOrderItemField()
    {
        return [
            'type' => Type::int(),
            'privacy' => function() {
                return $this->checkPermission("see-details-order_item");
            }
        ];
    }
}