<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ArrayDataType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ArrayData',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'type' => [
                'type' => Type::string()
            ],
            'value' => [
                'type' => Type::string()
            ],
        ];
    }
}