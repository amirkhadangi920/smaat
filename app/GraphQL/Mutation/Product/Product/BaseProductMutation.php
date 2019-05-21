<?php

namespace App\GraphQL\Mutation\Product\Product;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Product\ProductProps;
use Rebing\GraphQL\Support\UploadType;

class BaseProductMutation extends MainMutation
{
    use ProductProps;
    
    protected $attributes = [
        'name' => 'ProductMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'brand_id' => [
                'type' => Type::int()
            ],
            'category_id' => [
                'type' => Type::int()
            ],
            'unit_id' => [
                'type' => Type::int()
            ],
            'spec_id' => [
                'type' => Type::int()
            ],
            'parent_id' => [
                'type' => Type::int()
            ],
            'name' => [
                'type' => Type::string()
            ],
            'second_name' => [
                'type' => Type::string()
            ],
            'code' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'aparat_video' => [
                'type' => Type::string()
            ],
            'review' => [
                'type' => Type::string()
            ],
            'advantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'product' => [
                'type' => UploadType::getInstance()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}