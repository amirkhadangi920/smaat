<?php

namespace App\GraphQL\Mutation\Opinion\Review;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Opinion\ReviewProps;

class BaseReviewMutation extends MainMutation
{
    use ReviewProps;
    
    protected $attributes = [
        'name' => 'ReviewMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'product_id' => [
                'type' => Type::string()
            ],
            // 'ranks' => [
            //     'type' => Type::string()
            // ],
            'advantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'title' => [
                'type' => Type::string()
            ],
            'message' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}