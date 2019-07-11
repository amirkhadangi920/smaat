<?php

namespace App\GraphQL\Mutation\Opinion\QuestionAndAnswer;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteQuestionAndAnswerMutation extends BaseQuestionAndAnswerMutation
{
    use DeleteMutation;
}