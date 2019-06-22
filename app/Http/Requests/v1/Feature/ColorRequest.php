<?php

namespace App\Http\Requests\v1\Feature;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class ColorRequest extends MainRequest
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
            'name'              => [
                $this->requiredOrFilled(),
                'string',
                'max:50',
                new UniqueTenant('colors', $args['id'] ?? null)
            ],
            'code'              => [$this->requiredOrFilled(), 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', new UniqueTenant('colors')],
            'is_active'         => 'nullable|boolean',
            
            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'

        ];
    }
}
