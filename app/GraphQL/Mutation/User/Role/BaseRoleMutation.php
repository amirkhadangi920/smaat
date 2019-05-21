<?php

namespace App\GraphQL\Mutation\User\Role;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\RoleProps;

class BaseRoleMutation extends MainMutation
{
    use RoleProps;
    
    protected $attributes = [
        'name' => 'RoleMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'name' => [
                'type' => Type::string()
            ],
            'display_name' => [
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