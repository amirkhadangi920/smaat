<?php

namespace App\GraphQL\Query\Opinion\QuestionAndAnswer;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Opinion\QuestionAndAnswerProps;

class BaseQuestionAndAnswerQuery extends MainQuery
{
    use QuestionAndAnswerProps;

    protected $acceptable = false;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-question_and_answer');
    }

    public function applyFilters($args, $data)
    {
        $data->where('parent_id', null);
    }

    
}