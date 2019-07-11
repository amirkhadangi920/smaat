<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class MediaCustomPropertiesType extends GraphQLType
{
    protected $attributes = [
        'name' => 'MediaCustomProperties',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'color' => [
                'type' => Type::int(),
            ],
        ];
    }
}