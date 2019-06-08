<?php

namespace App\Http\Requests\v1\Opinion;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;

class ReviewRequest extends MainRequest
{
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
