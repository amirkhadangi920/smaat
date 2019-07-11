<?php

namespace App\GraphQL\Type\Group;

use App\GraphQL\Type\BaseType;
use App\Models\Group\Subject;
use GraphQL\Type\Definition\Type;

class SubjectType extends BaseType
{
    protected $attributes = [
        'name' => 'SubjectType',
        'description' => 'A type',
        'model' => Subject::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('subject'),
            'slug' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'icon' => [
                'type' => Type::string(),
            ],
            'parent' => $this->relationItemField('subject'),
            'childs' => $this->relationListField('subject'),
            'logo' => $this->imageField(),
            'audits' => $this->audits('subject'),
            'is_active' => $this->acceptableField('subject')
        ];
    }
}