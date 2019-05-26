<?php

namespace App\GraphQL\Type\Feature;

use GraphQL\Type\Definition\Type;
use App\Models\Feature\Color;

class ColorType extends BaseType
{
    protected $attributes = [
        'name' => 'ColorType',
        'description' => 'A type',
        'model' => Color::class
    ];

    public function more_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('color'),
            'name' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'code' => [
                'type' => Type::string()
            ],
            'audits' => $this->audits('color'),
            'is_active' => $this->acceptableField('color'),
        ];
    }
}