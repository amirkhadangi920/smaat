<?php

namespace App\GraphQL\Type\Group;

use App\GraphQL\Type\BaseType;
use App\Models\Group\Subject;

class SubjectType extends BaseType
{
    protected $attributes = [
        'name' => 'SubjectType',
        'description' => 'A type',
        'model' => Subject::class
    ];

    public function get_fields()
    {
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('subject'),
            'parent' => $this->relationItemField('category'),
            'childs' => $this->relationListField('subject'),
            'logo' => $this->imageField(),
            'audits' => $this->audits('subject'),
            'is_active' => $this->acceptableField('subject')
        ];
    }
}