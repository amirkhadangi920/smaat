<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\UserProps;
use Rebing\GraphQL\Support\UploadType;

class BaseUserMutation extends MainMutation
{
    use UserProps;
    
    protected $attributes = [
        'name' => 'UserMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'city_id' => [
                'type' => Type::int()
            ],
            'first_name' => [
                'type' => Type::string()
            ],
            'last_name' => [
                'type' => Type::string()
            ],
            'phones' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'social_links' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'email' => [
                'type' => Type::string()
            ],
            'password' => [
                'type' => Type::string()
            ],
            'password_confirmation' => [
                'type' => Type::string()
            ],
            'avatar' => [
                'type' => UploadType::getInstance()
            ],
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'national_code' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}