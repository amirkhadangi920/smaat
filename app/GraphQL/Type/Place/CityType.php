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
            'longitude‎' => [
                'type' => Type::float()
            ],
            'latitude‎' => [
                'type' => Type::float()
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