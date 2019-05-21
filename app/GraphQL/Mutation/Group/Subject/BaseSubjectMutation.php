<?php

namespace App\GraphQL\Mutation\Group\Subject;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Props\Group\SubjectProps;

class BaseSubjectMutation extends MainMutation
{
    use SubjectProps;
    
    protected $attributes = [
        'name' => 'SubjectMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'parent_id' => [
                'type' => Type::int()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}