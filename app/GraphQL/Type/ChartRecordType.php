<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ChartRecordType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ChartRecordType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'month' => [
                'type' => Type::string()
            ],
            'count' => [
                'type' => Type::int()
            ],
        ];
    }
}