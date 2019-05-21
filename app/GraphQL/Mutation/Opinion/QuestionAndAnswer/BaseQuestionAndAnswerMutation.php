<?php

namespace App\GraphQL\Mutation\Opinion\QuestionAndAnswer;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Opinion\QuestionAndAnswerProps;

class BaseQuestionAndAnswerMutation extends MainMutation
{
    use QuestionAndAnswerProps;
    
    protected $attributes = [
        'name' => 'QuestionAndAnswerMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'product_id' => [
                'type' => Type::string()
            ],
            'question_id' => [
                'type' => Type::int()
            ],
            'message' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}