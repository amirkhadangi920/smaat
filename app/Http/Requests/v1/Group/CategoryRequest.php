<?php

namespace App\Http\Requests\v1\Group;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'title'             => 'required|string|min:50',
            'description'       => 'nullable|string|min:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'scoring_feilds'    => 'nullable|string|array',
            'scoring_feilds.*'  => 'required|string|max:100',

            /* relateion */
            'parent_id'         => 'nullable|integer|exists:categories,id',
            
            'keywords'          => 'nullable|array',
            'keywords.*'        => 'required|string|max:100',
        ];
    }
}
