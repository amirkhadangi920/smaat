<?php

namespace App\Http\Requests\User\v1;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class UserRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name'        => 'nullable|string|max:20',
            'first_name'        => 'nullable|string|max:30',
            'phones'            => 'nullable|array',
            'phones.*'          => ['required', 'string', 'regex:/09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}/'],
            'social_links'      => 'nullable|array',
            'social_links.*'    => 'required|string|max:100',
            'email'             => ['required', new UniqueTenant('users')],
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'address'           => 'nullable|string|max:255',
            'postal_code'       => 'nullable|digits:10',
            
            // relations
            'city_id'           => ['nullable', 'integer', new ExistsTenant('cities')],

            'permissions'       => ['nullable', 'array', new ExistsTenant],
            'permissions.*'     => 'required|integer',
            
            'roles'             => ['nullable', 'array', new ExistsTenant],
            'roles.*'           => 'required|integer',
        ];

        if ( $this->method() === 'PUT' && $this->route('user')->email === $this->email )
            $rules['email'] = 'required';

        return $rules;
    }
}
