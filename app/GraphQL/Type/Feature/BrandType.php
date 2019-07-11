<?php

namespace App\GraphQL\Type\Feature;

use GraphQL\Type\Definition\Type;
use App\Models\Feature\Brand;

class BrandType extends BaseType
{
    protected $has_active_status = true;

    protected $attributes = [
        'name' => 'BrandType',
        'description' => 'A type',
        'model' => Brand::class
    ];

    public function more_fields()
    {
        return [
            'slug' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'name' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('brand'),
            'logo' => $this->imageField(),
            'is_active' => $this->acceptableField('brand'),
            'audits' => $this->audits('brand')
        ];
    }
}