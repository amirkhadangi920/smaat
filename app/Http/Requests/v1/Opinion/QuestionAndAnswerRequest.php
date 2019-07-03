<?php

namespace App\Http\Requests\v1\Opinion;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;

class QuestionAndAnswerRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($args, $method)
    {
        $this->method = $method;

        return [
            'title'             => 'required_without:question_id|string|max:100',
            'message'           => 'required|string|max:2000',

            /* relateion */
            'question_id'       => ['nullable', 'integer', new ExistsTenant('question_and_answers')],
            'product_id'        => ['required_without:question_id', 'string', new ExistsTenant('products')],
        ];
    }
}
