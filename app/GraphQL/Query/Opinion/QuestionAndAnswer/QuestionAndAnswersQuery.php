<?php

namespace App\GraphQL\Query\Opinion\QuestionAndAnswer;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class QuestionAndAnswersQuery extends BaseQuestionAndAnswerQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_answer' => [
                'type' => Type::boolean()
            ],
            'is_accept' => [
                'type' => Type::boolean()
            ],
            'writers' => [
                'type' => Type::listOf( Type::string() )
            ],
            'products' => [
                'type' => Type::listOf( Type::string() )
            ],
        ];
    }
}