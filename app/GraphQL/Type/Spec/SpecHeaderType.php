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
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('specification'),
            'rows' => $this->relationListField('spec_row', 'is_active', 'read-specification'),
            'audits' => $this->audits('specification'),
            'is_active' => $this->acceptableField('specification')
        ];
    }
}