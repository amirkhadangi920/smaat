<?php

namespace App\GraphQL\Mutation\Feature\Unit;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Props\Feature\UnitProps;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Mutation\Feature\FeaturesCategoriesMutation;

class BaseUnitMutation extends MainMutation
{
    use UnitProps, FeaturesCategoriesMutation;

    protected $attributes = [
        'name' => 'UnitMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
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