<?php

namespace App\GraphQL\Mutation\Spec\SpecRow;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecRowProps;

class BaseSpecRowMutation extends MainMutation
{
    use SpecRowProps;
    
    protected $permission_label = 'spec';
    
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
            'prefix' => [
                'type' => Type::string()
            ],
            'postfix' => [
                'type' => Type::string()
            ],
            'help' => [
                'type' => Type::string()
            ],
            'is_multiple' => [
                'type' => Type::boolean()
            ],
            'is_required' => [
                'type' => Type::boolean()
            ],
            'is_filterable' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}