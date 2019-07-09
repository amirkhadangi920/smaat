<?php

namespace App\Http\Requests\User\v1;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueUserPhoneAddress;

class UserPhoneRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($args, $method)
    {
        $this->method = $method;
        
        return [
            'type'          => 'required|string|max:20',
            'phone_number'  => [
                'required',
                'string',
                'regex:/09(1[0-9]|3[1-9]|2[1-9]0[1-9])-?[0-9]{3}-?[0-9]{4}/',
                new UniqueUserPhoneAddress('user_phones', $args['id'] ?? null)
            ],
        ];
    }
}
