<?php

namespace App\GraphQL\Type\Place;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Places\City;

class CityType extends BaseType
{
    protected $attributes = [
        'name' => 'CityType',
        'description' => 'A type',
        'model' => City::class
    ];

    public function get_fields()
    {
        return [
            'coordinates' => [
                'type' => \GraphQL::type('coordinate'),
                'is_relation' => false
            ],
            'name' => [
                'type' => Type::string()
            ],
            'province' => [
                'type' => \GraphQL::type('province')
            ]
        ];
    }
}