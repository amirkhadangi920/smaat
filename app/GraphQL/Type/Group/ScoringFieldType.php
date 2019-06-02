<?php

namespace App\GraphQL\Type\Group;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Group\ScoringField;

class ScoringFieldType extends BaseType
{
    protected $attributes = [
        'name' => 'ScoringFieldType',
        'description' => 'A type',
        'model' => ScoringField::class
    ];

    public function get_fields()
    {
        return [
            'default' => [
                'type' => Type::int(),
            ],
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'value' => [
                'type' => Type::int(),
                'resolve' => function($data) {
                    return $data->pivot->value ?? null;
                },
                'selectable' => false
            ],
        ];
    }
}