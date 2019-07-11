<?php

namespace App\GraphQL\Mutation\Spec\SpecDefault;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecDefaultProps;

class BaseSpecDefaultMutation extends MainMutation
{
    use SpecDefaultProps;
    
    protected $permission_label = 'spec';
    
    protected $attributes = [
        'name' => 'SpecDefaultMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'spec_row_id' => [
                'type' => Type::int()
            ],
            'value' => [
                'type' => Type::string()
            ]
        ];
    }
}