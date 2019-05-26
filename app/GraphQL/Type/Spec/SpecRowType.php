<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\SpecRow;

class SpecRowType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecRowType',
        'description' => 'A type',
        'model' => SpecRow::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('specification'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'label' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'values' => [
                'type' => Type::listOf( Type::string() )
            ],
            'help' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'multiple' => [
                'type' => Type::boolean()
            ],
            'required' => [
                'type' => Type::boolean()
            ],
            'audits' => $this->audits('specification'),
            'is_active' => $this->acceptableField('specification')
        ];
    }
}