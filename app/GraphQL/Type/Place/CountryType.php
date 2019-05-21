<?php

namespace App\GraphQL\Type\Place;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Places\Country;

class CountryType extends BaseType
{
    protected $attributes = [
        'name' => 'CountryType',
        'description' => 'A type',
        'model' => Country::class
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
            'provinces' => [
                'type' => Type::listOf( \GraphQL::type('province') )
            ]
        ];
    }
}