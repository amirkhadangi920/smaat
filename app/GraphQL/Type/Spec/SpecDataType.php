<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\SpecData;

class SpecDataType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecDataType',
        'description' => 'A type',
        'model' => SpecData::class
    ];

    public function get_fields()
    {
        return [
            'data' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'values' => [
                'type' => Type::listOf( \GraphQL::type('spec_default') ),
            ]
        ];
    }
}