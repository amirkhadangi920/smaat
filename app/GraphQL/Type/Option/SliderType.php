<?php

namespace App\GraphQL\Type\Option;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class SliderType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SliderType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'image' => [
                'type' => \GraphQL::type('single_media'),
            ],
            'title' => [
                'type' => Type::string(),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'button' => [
                'type' => Type::string(),
            ],
            'link' => [
                'type' => Type::string(),
            ],
        ];
    }
}