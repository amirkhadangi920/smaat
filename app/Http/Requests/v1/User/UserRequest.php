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
    public function rules($args, $method)
    {
        $this->method = $method;
        
        return [
            'first_name'        => 'nullable|string|max:20',
            'first_name'        => 'nullable|string|max:30',
            // 'social_links'      => 'nullable|array',
            // 'social_links.*'    => 'required|string|max:100',
            'email'             => [
                $this->requiredOrFilled(),
                'email',
                new UniqueTenant('users', $args['id'] ?? null, null, false)
            ],
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'national_code'     => 'nullable|size:10',
            'gender'            => 'nullable|boolean',
            
            // relations
            'city_id'           => ['nullable', 'integer', new ExistsTenant('cities')],

            'permissions'       => 'nullable|array',
            'permissions.*'     => 'required|integer|exists:permissions,id',
            
            'roles'             => ['nullable', 'array', new ExistsTenant],
            'roles.*'           => 'required|integer',
        ];
    }
}
