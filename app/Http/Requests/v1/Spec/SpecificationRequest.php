<?php

namespace App\Http\Requests\v1\Spec;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

class SpecificationRequest extends FormRequest
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
            'title'             => ['required', 'string', 'max:50', new UniqueTenant('specs')],
            'description'       => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',
            
            /**
             * relateion 
             */
            'categories'        => ['required', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'
        ];
    }
}
