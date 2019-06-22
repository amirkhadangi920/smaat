<?php

namespace App\Http\Requests\v1\Spec;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;
use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueInSpec;

class SpecificationHeaderRequest extends MainRequest
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
                new UniqueInSpec('spec_headers', $args, 'spec_id')
            ],
            'description'       => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',
            
            /**
             * relateion 
             */
            'spec_id'           => ['required', 'integer', new ExistsTenant('specs')],
        ];
    }
}
