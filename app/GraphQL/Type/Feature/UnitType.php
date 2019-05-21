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
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('unit'),
            'audits' => $this->audits('unit'),
            'is_active' => $this->acceptableField('unit'),
        ];
    }
}