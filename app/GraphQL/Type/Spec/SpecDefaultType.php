<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\SpecDefault;

class SpecDefaultType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecDefaultType',
        'description' => 'A type',
        'model' => SpecDefault::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int()
            ],
            'value' => [
                'type' => Type::string(),
                'selectable' => false
            ],
        ];
    }
}