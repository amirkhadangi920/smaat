<?php

namespace App\Http\Requests\v1\Opinion;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'ranks'             => 'nullable|array',
            'advantages'        => 'nullable|array',
            'disadvantages'     => 'nullable|array',
            'message'           => 'required|array|string',

            /**
             * relateion 
             */
            'users.*'           => 'required|array|exists:users,id',
            'articles.*'        => 'required|array|exists:articles,id',
        ];
    }
}
