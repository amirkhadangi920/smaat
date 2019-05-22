<?php

namespace App\Http\Requests\v1\Opinion;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsTenant;

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
            'parent_id'         => ['nullable', 'integer', new ExistsTenant('question_and_answers')],
            'product_id'        => ['required', 'string', new ExistsTenant('products')],
        ];
    }
}
