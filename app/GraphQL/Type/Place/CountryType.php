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
            'coordinates' => [
                'type' => \GraphQL::type('coordinate'),
                'is_relation' => false
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