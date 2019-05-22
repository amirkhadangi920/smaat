<?php

namespace App\Http\Requests\v1\Opinion;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsTenant;

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
            'ranks.*'           => 'required|string|max:100',
            'advantages'        => 'nullable|array',
            'advantages.*'      => 'required|string|max:100',
            'disadvantages'     => 'nullable|array',
            'disadvantages.*'   => 'required|string|max:100',
            'message'           => 'required|string',

            /* relateion */
            'product_id'        => ['required', 'string', new ExistsTenant('products')],
        ];
    }
}
