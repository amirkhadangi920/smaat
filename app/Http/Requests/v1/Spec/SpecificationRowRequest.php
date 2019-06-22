<?php

namespace App\Http\Requests\v1\Spec;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;
use App\Rules\UniqueInSpec;

class SpecificationRowRequest extends MainRequest
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
            'title'                     => [
                'required',
                'string',
                'max:50',
                new UniqueInSpec('spec_rows', $args, 'spec_header_id')
            ],
            'description'               => 'nullable|string|max:255',
            'label'                     => 'nullable|string|max:50',
            'values'                    => 'nullable|array',
            'help'                      => 'nullable|string|max:255',
            'is_multiple'               => 'nullable|boolean',
            'is_required'               => 'nullable|boolean',
            'is_filterable'             => 'nullable|boolean',
            'is_active'                 => 'nullable|boolean',
            
            /**
             * relateion 
             */
            'spec_header_id'            => ['required', 'integer', 'exists:spec_headers,id'],
        ];
    }
}
