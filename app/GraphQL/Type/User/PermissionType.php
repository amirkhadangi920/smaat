<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Permission;

class PermissionType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'PermissionType',
        'description' => 'A type',
        'model' => Permission::class
    ];

    public function get_fields()
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
            'roles' => $this->relationListField('role')
        ];
    }
}