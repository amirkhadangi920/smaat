<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Discount\Discount;

class DiscountType extends BaseType
{
    protected $attributes = [
        'name' => 'DiscountType',
        'description' => 'A type',
        'model' => Discount::class
    ];

    public function get_fields()
    {
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('discount'),
            'logo' => $this->imageField(),
            'started_at' => [
                'type' => Type::string()
            ],
            'expired_at' => [
                'type' => Type::string()
            ],
            'categories' => $this->relationListField('category'),
            'items' => [
                'type' => Type::listOf( \GraphQl::type('discount_item') ),
            ],
            'audits' => $this->audits('discount'),
            'is_active' => $this->acceptableField('discount')
        ];
    }
}