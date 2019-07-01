<?php

namespace App\Http\Requests\User\v1;

use App\Http\Requests\v1\MainRequest;

class PasswordResetRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ];
    }
}
