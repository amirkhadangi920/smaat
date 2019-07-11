<?php

namespace App\GraphQL\Type\Product;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Product\Variation;

class VariationType extends BaseType
{
    public $incrementing = false;
    
    protected $attributes = [
        'name' => 'VariationType',
        'description' => 'A type',
        'model' => Variation::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('variation'),
            'sales_price' => [
                'type' => Type::int()
            ],
            'old_sale_prices' => [
                'type' => Type::listOf( \GraphQL::type('price_change') )
            ],
            'inventory' => [
                'type' => Type::int(),
            ],
            'sending_time' => [
                'type' => Type::int()
            ],
            'color' => $this->relationItemField('color'),
            'warranty' => $this->relationItemField('warranty'),
            'size' => $this->relationItemField('size'),
            'product' => $this->relationItemField('product'),
            'audits' => $this->audits('product'),
            'is_active' => $this->acceptableField('product')
        ];
    }
}