<?php

namespace App\GraphQL\Type\Opinion;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Opinion\QuestionAndAnswer;

class QuestionAndAnswerType extends BaseType
{
    protected $attributes = [
        'name' => 'QuestionAndAnswerType',
        'description' => 'A type',
        'model' => QuestionAndAnswer::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('question_and_answer'),
            'title' => [
                'type' => Type::string()
            ],
            'message' => [
                'type' => Type::string()
            ],
            'writer' => [
                'type' => \GraphQL::type('user'),
            ],
            'votes' => $this->votes(),
            'product' => $this->relationItemField('product'),
            'question' => $this->relationItemField('question_and_answer', 'is_accept'),
            'answers' => $this->relationListField('question_and_answer', 'is_accept'),
            'audits' => $this->audits('question_and_answer'),
            'is_accept' => [
                'type' => Type::boolean(),
            ],
        ];
    }
}