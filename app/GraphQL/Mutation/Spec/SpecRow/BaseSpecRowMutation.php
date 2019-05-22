<?php

namespace App\GraphQL\Mutation\Spec\SpecRow;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecRowProps;

class BaseSpecRowMutation extends MainMutation
{
    use SpecRowProps;
    
    protected $permission_label = 'specification';
    
    protected $attributes = [
        'name' => 'SpecRowMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'spec_header_id' => [
                'type' => Type::int()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'label' => [
                'type' => Type::string()
            ],
            'values' => [
                'type' => Type::listOf( Type::string() )
            ],
            'help' => [
                'type' => Type::string()
            ],
            'multiple' => [
                'type' => Type::boolean()
            ],
            'multiple' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}