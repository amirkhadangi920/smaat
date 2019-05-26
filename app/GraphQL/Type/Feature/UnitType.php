<?php

namespace App\GraphQL\Type\Feature;

use GraphQL\Type\Definition\Type;
use App\Models\Feature\Unit;

class UnitType extends BaseType
{
    protected $attributes = [
        'name' => 'UnitType',
        'description' => 'A type',
        'model' => Unit::class
    ];

    public function more_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('unit'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'audits' => $this->audits('unit'),
            'is_active' => $this->acceptableField('unit'),
        ];
    }
}