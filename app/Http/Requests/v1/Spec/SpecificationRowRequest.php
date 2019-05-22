<?php

namespace App\Http\Requests\v1\Spec;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;

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
    public function rules($args)
    {
        return [
            'title'                     => [
                'required',
                'string',
                'min:50',
                Rule::unique('spec_rows')->where(function ($query) use($args) {
                    return $query->where('spec_header_id', $args['spec_header_id']);
                })
            ],
            'description'               => 'nullable|string|min:255',
            'label'                     => 'nullable|string|min:50',
            'values'                    => 'required|array|string',
            'help'                      => 'nullable|string|max:255',
            'multiple'                  => 'required|boolean',
            'required'                  => 'required|boolean',
            'is_active'                 => 'nullable|boolean',
            
            /**
             * relateion 
             */
            'spec_header_id'            => ['required', 'integer', new ExistsTenant('spec_headers')],
        ];
    }
}
