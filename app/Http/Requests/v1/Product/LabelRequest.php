<?php

namespace App\Http\Requests\v1\Product;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;

class LabelRequest extends MainRequest
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
            'color'         => [
                'nullable',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
                new UniqueTenant('labels', $args['id'] ?? null)
            ],
            'title'              => [
                $this->requiredOrFilled(),
                'string',
                'max:50',
                new UniqueTenant('labels', $args['id'] ?? null)
            ],
            'description'       => 'nullable|string|max:250',
        ];
    }
}
