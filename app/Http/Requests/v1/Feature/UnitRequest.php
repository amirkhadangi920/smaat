<?php

namespace App\Http\Requests\v1\Feature;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class UnitRequest extends MainRequest
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
                $this->requiredOrFilled(),
                'string',
                'max:50',
                new UniqueTenant('units', $args['id'] ?? null)
            ],
            'description'       => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',

            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'
        ];
    }
}
