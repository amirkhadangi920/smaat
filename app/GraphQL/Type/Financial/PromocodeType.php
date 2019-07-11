<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Promocode\Promocode;

class PromocodeType extends BaseType
{
    protected $attributes = [
        'name' => 'PromocodeType',
        'description' => 'A type',
        'model' => Promocode::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'code' => [
                'type' => Type::string(),
            ],
            'value' => [
                'type' => Type::int(),
            ],
            'min_total' => [
                'type' => Type::int(),
            ],
            'max' => [
                'type' => Type::int(),
            ],
            'quantity' => [
                'type' => Type::int(),
            ],
            'expired_at' => [
                'type' => Type::string(),
            ],
            'creator' => $this->creator('discount'),
            'categories' => $this->relationListField('category'),
            'variations' => $this->relationListField('variation', 'is_active', 'read-product'),
            'users' => [
                'type' => Type::listOf( \GraphQL::type('user') )
            ],
            'audits' => $this->audits('discount'),
            'is_active' => $this->acceptableField('discount')
        ];
    }
}