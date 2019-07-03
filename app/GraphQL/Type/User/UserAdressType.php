<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\UserAddress;

class UserAddressType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'UserAddressType',
        'description' => 'A type',
        'model' => UserAddress::class
    ];

    public function get_fields()
    {
        return [
            'city' => [
                'type' => \GraphQL::type('city')
            ],
            'type' => [
                'type' => Type::string()
            ],
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'coordinates' => [
                'type' => \GraphQL::type('coordinate'),
                'is_relation' => false
            ],
        ];
    }
}