<?php

namespace App\Http\Requests\v1\Feature;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class ColorRequest extends FormRequest
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
            'name'              => ['required', 'string', 'max:50', new UniqueTenant('colors')],
            'code'              => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', new UniqueTenant('colors')],
            'is_active'         => 'nullable|boolean',
            
            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'

        ];
    }
}
