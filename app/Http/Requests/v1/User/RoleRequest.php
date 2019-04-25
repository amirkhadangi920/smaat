<?php

namespace App\Http\Requests\User\v1;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;

class RoleRequest extends FormRequest
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
        $rules = [
            'display_name'  => ['required', 'string', 'max:100', new UniqueTenant('roles')],
            'description'   => 'nullable|string|max:255',
            'permissions'   => 'required|array',
            'permissions.*' => 'required|integer|exists:permissions,id',
        ];
        
        if ( request()->method() !== 'POST' )
            $rules['display_name'] = 'required|string|max:100';

        return $rules;
    }
}
