<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Role;

class RoleType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'RoleType',
        'description' => 'A type',
        'model' => Role::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('role'),
            'name' => [
                'type' => Type::string()
            ],
            'display_name' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'permissions' => [
                'type' => Type::listOf( \GraphQL::type('permission') )
            ],
            'audits' => $this->audits('specification'),
            'is_active' => $this->acceptableField('role')
        ];
    }
}