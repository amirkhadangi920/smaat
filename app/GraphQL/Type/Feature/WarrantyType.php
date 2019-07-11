<?php

namespace App\GraphQL\Type\Feature;

use GraphQL\Type\Definition\Type;
use App\Models\Feature\Warranty;

class WarrantyType extends BaseType
{
    protected $attributes = [
        'name' => 'WarrantyType',
        'description' => 'A type',
        'model' => Warranty::class
    ];

    public function more_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('warranty'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'expire' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'logo' => $this->imageField(),
            'audits' => $this->audits('warranty'),
            'is_active' => $this->acceptableField('warranty'),
        ];
    }
}