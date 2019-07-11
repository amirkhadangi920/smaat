<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use OwenIt\Auditing\Models\Audit;

class AuditType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AuditType',
        'description' => 'A type',
        'model' => Audit::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int()
            ],
            'event' => [
                'type' => Type::string()
            ],
            'ip_address' => [
                'type' => Type::string()
            ],
            'old_values' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return json_encode($data->old_values);
                },
                'is_relation' => false,
            ],
            'new_values' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return json_encode($data->new_values);
                },
                'is_relation' => false,
            ],
            'user_agent' => [
                'type' => Type::string()
            ],
            'created_at' => [
                'type' => Type::string()
            ],
            'tags' => [
                'type' => Type::string()
            ],
            'user' => [
                'type' => \GraphQL::type('user'),
            ]
        ];
    }
}