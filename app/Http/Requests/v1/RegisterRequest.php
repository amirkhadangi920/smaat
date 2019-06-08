<?php

namespace App\Http\Requests\v1;

use App\Rules\UniqueTenant;

class RegisterRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [ 'required', 'email', new UniqueTenant('users', null, false) ], 
            'password' => 'required|confirmed', 
        ];
    }
}
