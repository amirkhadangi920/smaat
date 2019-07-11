<?php

namespace App\GraphQL\Mutation\Spec\SpecHeader;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecHeaderProps;

class BaseSpecHeaderMutation extends MainMutation
{
    use SpecHeaderProps;
    
    protected $permission_label = 'spec';

    protected $attributes = [
        'name' => 'SpecHeaderMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'spec_id' => [
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