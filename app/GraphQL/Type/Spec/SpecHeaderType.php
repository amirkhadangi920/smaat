<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\SpecHeader;

class SpecHeaderType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecHeaderType',
        'description' => 'A type',
        'model' => SpecHeader::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('spec'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'rows' => $this->relationListField('spec_row', 'is_active', 'read-spec'),
            'audits' => $this->audits('spec'),
            'is_active' => $this->acceptableField('spec')
        ];
    }
}