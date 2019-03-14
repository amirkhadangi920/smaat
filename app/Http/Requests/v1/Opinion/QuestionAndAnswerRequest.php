<?php

namespace App\Http\Requests\v1\Opinion;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAndAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message'           => 'required|string',

            /* relateion */
            'question_id'       => 'nullable|integer|exists:question_and_answers,id',
            'product_id'        => 'required|string|exists:products,id',
        ];
    }
}