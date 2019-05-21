<?php

namespace App\GraphQL\Type\Place;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Places\Province;

class ProvinceType extends BaseType
{
    protected $attributes = [
        'name' => 'ProvinceType',
        'description' => 'A type',
        'model' => Province::class
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
            'country' => [
                'type' => \GraphQL::type('country')
            ],
            'cities' => [
                'type' => Type::listOf( \GraphQL::type('city') )
            ]
        ];
    }
}