<?php

namespace App\GraphQL\Query\Group\Subject;

use App\GraphQL\Helpers\SingleQuery;
use GraphQL\Type\Definition\Type;

class SubjectQuery extends BaseSubjectQuery
{
    use SingleQuery;

    public function args()
    {
        return [
            'id' => [
                'type' => $this->incrementing ? Type::int() : Type::string(),
                'rules' => 'required_without:slug'
            ],
            'slug' => [
                'type' => Type::string(),
                'rules' => 'required_without:id'
            ]
        ];
    }
}