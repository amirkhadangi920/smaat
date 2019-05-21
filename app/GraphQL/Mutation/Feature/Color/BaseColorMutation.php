<?php

namespace App\GraphQL\Mutation\Feature\Color;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Props\Feature\ColorProps;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Mutation\Feature\FeaturesCategoriesMutation;

class BaseColorMutation extends MainMutation
{
    use ColorProps, FeaturesCategoriesMutation;

    protected $attributes = [
        'name' => 'ColorMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'name' => [
                'type' => Type::string()
            ],
            'code' => [
                'type' => Type::string()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}