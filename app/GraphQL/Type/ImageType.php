<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ImageType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ImageType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'big' => [
                'type' => Type::string()
            ],
            'medium' => [
                'type' => Type::string()
            ],
            'small' => [
                'type' => Type::string()
            ],
            'tiny' => [
                'type' => Type::string()
            ],
        ];
    }
}