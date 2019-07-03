<?php

namespace App\GraphQL\Mutation\User\UserPhone;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\UserPhoneProps;

class BaseUserPhoneMutation extends MainMutation
{
    use UserPhoneProps;
    
    protected $attributes = [
        'name' => 'UserPhoneMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'type' => [
                'type' => Type::string()
            ],
            'phone_number' => [
                'type' => Type::string()
            ]
        ];
    }
}