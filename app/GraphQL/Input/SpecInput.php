<?php

namespace App\GraphQL\Input;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class SpecInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'SpecInput',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int()
            ],
            'value' => [
                'type' => Type::int()
            ],
            'values' => [
                'type' => Type::listOf( Type::int() )
            ],
            'data' => [
                'type' => Type::string()
            ],
        ];
    }
}