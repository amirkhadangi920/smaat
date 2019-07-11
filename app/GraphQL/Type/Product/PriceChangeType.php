<?php

namespace App\GraphQL\Type\Product;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Product\PriceChange;

class PriceChangeType extends BaseType
{
    public $incrementing = false;
    
    protected $attributes = [
        'name' => 'PriceChangeType',
        'description' => 'A type',
        'model' => PriceChange::class
    ];

    public function get_fields()
    {
        return [
            'old_price' => [
                'type' => Type::int()
            ],
            'changed_at' => [
                'type' => Type::string(),
            ],
        ];
    }
}