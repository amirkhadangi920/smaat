<?php

namespace App\Http\Requests\v1\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'          => 'nullable|max:50|string',
            'second_name'   => 'nullable|max:50|string',
            'code'          => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'description'   => 'nullable|max:255|string',
            'note'          => 'nullable|max:255|string',
            // 'aparat_video'  => 'nullable|' ,
            'status'        => 'nullable|boolean|digits_between:0,127',
            'review'        => 'nullable|string',
            'advantages'    => 'required|string|array',
            'disadvantages' => 'required|string|array',
            'label'         => 'nullable|digit',
            'views_count'   => 'required|digits_between:0,1000000',
            'photos'        => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024'
        ];
    }
}
