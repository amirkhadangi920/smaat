<?php

namespace App\Http\Requests\User\v1;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueUserPhoneAddress;

class UserAddressRequest extends MainRequest
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
            'city_id'       => 'required|integer|exists:cities,id',
            'type'          => 'required|string|max:20',
            'full_name'     => 'required|string|max:50',
            'phone_number'  => [
                'required',
                'string',
                'regex:/^(\+98|0)?9\d{9}$/',
            ],
            'address'       => [
                'required',
                'string',
                'max:100',
                new UniqueUserPhoneAddress('user_addresses', $args['id'] ?? null)
            ],
            'postal_code'   => [
                'required',
                'string',
                'digits:10',
                new UniqueUserPhoneAddress('user_addresses', $args['id'] ?? null)
            ],
            'lat'           => 'required|numeric',
            'lng'           => 'required|numeric',
        ];
    }
}
