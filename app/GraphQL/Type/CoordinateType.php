<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class CoordinateType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CoordinateType',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'lat' => [
                'type' => Type::float(),
                'resolve' => function($data) {
                    return $data ? $data->getLat() : null;
                }
            ],
            'lng' => [
                'type' => Type::float(),
                'resolve' => function($data) {
                    return $data ? $data->getLng() : null;
                }
            ],
        ];
    }
}