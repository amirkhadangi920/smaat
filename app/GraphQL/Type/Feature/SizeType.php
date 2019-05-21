<?php

namespace App\GraphQL\Type\Feature;

use GraphQL\Type\Definition\Type;
use App\Models\Feature\Size;

class SizeType extends BaseType
{
    protected $attributes = [
        'name' => 'SizeType',
        'description' => 'A type',
        'model' => Size::class
    ];

    public function more_fields()
    {
        return $this->infoField('name') + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('size'),
            'audits' => $this->audits('size'),
            'is_active' => $this->acceptableField('size'),
        ];
    }
}