<?php

namespace App\GraphQL\Type\Group;

use App\Models\Group\Category;
use App\GraphQL\Type\BaseType;

class CategoryType extends BaseType
{
    protected $attributes = [
        'name' => 'category',
        'description' => 'A type',
        'model' => Category::class
    ];

    public function get_fields()
    {
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('category'),
            'parent' => $this->relationItemField('category'),
            'logo' => $this->imageField(),
            'childs' => $this->relationListField('category'),
            'brands' => $this->relationListField('brand'),
            'colors' => $this->relationListField('color'),
            'sizes' => $this->relationListField('size'),
            'warranties' => $this->relationListField('warranty'),
            'audits' => $this->audits('category'),
            'is_active' => $this->acceptableField('category')
        ];
    }
}