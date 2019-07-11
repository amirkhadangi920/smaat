<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\UserPhone;

class UserPhoneType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'UserPhoneType',
        'description' => 'A type',
        'model' => UserPhone::class
    ];

    public function get_fields()
    {
        return [
            'type' => [
                'type' => Type::string()
            ],
            'phone_number' => [
                'type' => Type::string()
            ],
        ];
    }
}