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
                'regex:/^(\+98|0)?9\d{9}$/',
                new UniqueUserPhoneAddress('user_phones', $args['id'] ?? null)
            ],
        ];
    }
}
