<?php

namespace App\Http\Requests\v1;

use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

class RegisterRequest extends MainRequest
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
            'first_name'        => 'nullable|string|max:20',
            'first_name'        => 'nullable|string|max:30',
            'email'             => [
                'required',
                'email',
                new UniqueTenant('users', $args['id'] ?? null, null, false)
            ],
            'password'          => 'required|confirmed', 
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'national_code'     => 'nullable|size:10',
            'gender'            => 'nullable|boolean',
            
            // relations
            'city_id'           => ['nullable', 'integer', new ExistsTenant('cities')],
        ];
    }
}
