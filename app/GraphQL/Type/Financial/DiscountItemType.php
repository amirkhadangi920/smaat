<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Discount\DiscountItem;

class DiscountItemType extends BaseType
{
    protected $attributes = [
        'name' => 'DiscountItemType',
        'description' => 'A type',
        'model' => DiscountItem::class
    ];

    public function get_fields()
    {
        return [
            'offer' => [
                'type' => Type::int()
            ],
            'quantity' => [
                'type' => Type::int()
            ],
            'variation' => $this->relationItemField('variation', 'is_active', 'read-product')
        ];
    }
}