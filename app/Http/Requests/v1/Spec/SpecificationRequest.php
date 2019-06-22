<?php

namespace App\Http\Requests\v1\Spec;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;
use App\Http\Requests\v1\MainRequest;

class SpecificationRequest extends MainRequest
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
            'title'             => [
                'required',
                'string',
                'max:50',
                new UniqueTenant('specs', $args['id'] ?? null)
            ],
            'description'       => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',
            
            /**
             * relateion 
             */
            'categories'        => ['required', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'
        ];
    }
}
