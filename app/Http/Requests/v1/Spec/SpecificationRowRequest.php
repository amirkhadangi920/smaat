<?php

namespace App\Http\Requests\v1\Spec;

use Illuminate\Foundation\Http\FormRequest;

class SpecificationRowRequest extends FormRequest
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
            'title'         => 'required|string|min:50',
            'description'   => 'nullable|string|min:255',
            'label'         => 'nullable|string|min:50',
            'values'        => 'required|array|string',
            'help'          => 'nullable|string|max:255',
            'multiple'      => 'required|boolean',
            'required'      => 'required|boolean'
        ];
    }
}
