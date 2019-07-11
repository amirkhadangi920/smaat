<?php

namespace App\GraphQL\Mutation\Opinion\QuestionAndAnswer;

use App\GraphQL\Helpers\CreateMutation;

class CreateQuestionAndAnswerMutation extends BaseQuestionAndAnswerMutation
{
    use CreateMutation;

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        $request->put('is_accept', auth()->user()->can("read-{$this->type}"));

        return $request->all();
    }
}