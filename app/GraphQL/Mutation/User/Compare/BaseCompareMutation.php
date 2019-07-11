<?php

namespace App\GraphQL\Mutation\User\Compare;

use App\GraphQL\Mutation\MainMutation;
use GraphQL\Type\Definition\Type;

class BaseCompareMutation extends MainMutation
{    
    protected $attributes = [
        'name' => 'CompareMutation',
        'description' => 'A mutation'
    ];
    
    public function type()
    {
        return \GraphQL::type('result');
    }

    public function args()
    {
        return [
            'product' => [
                'type' => Type::nonNull( Type::string() ),
            ],
        ];
    }
}