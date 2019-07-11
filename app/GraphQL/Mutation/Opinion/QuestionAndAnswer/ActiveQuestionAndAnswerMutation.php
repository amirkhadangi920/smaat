<?php

namespace App\GraphQL\Mutation\Opinion\QuestionAndAnswer;

use App\GraphQL\Helpers\ActiveMutation;

class ActiveQuestionAndAnswerMutation extends BaseQuestionAndAnswerMutation
{
    use ActiveMutation;

    protected $acceptable_field = 'is_accept';
}