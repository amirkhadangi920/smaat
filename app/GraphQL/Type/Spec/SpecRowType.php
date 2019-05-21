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
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('specification'),
            'label' => [
                'type' => Type::string()
            ],
            'values' => [
                'type' => Type::listOf( Type::string() )
            ],
            'help' => [
                'type' => Type::string()
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