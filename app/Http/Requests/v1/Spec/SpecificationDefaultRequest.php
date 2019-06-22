<?php

namespace App\Http\Requests\v1\Spec;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueInSpec;

class SpecificationDefaultRequest extends MainRequest
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
            'value'                     => [
                'required',
                'string',
                'max:100',
                new UniqueInSpec('spec_defaults', $args, 'spec_row_id')
            ],

            /**
             * relateion 
             */
            'spec_row_id'            => ['required', 'integer', 'exists:spec_rows,id'],
        ];
    }
}
