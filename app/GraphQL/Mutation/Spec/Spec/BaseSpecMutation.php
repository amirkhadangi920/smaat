<?php

namespace App\GraphQL\Mutation\Spec\Spec;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecProps;

class BaseSpecMutation extends MainMutation
{
    use SpecProps;
    
    protected $attributes = [
        'name' => 'SpecMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'category_id' => [
                'type' => Type::int()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}