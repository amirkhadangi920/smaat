<?php

namespace App\Http\Requests\v1\Feature;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class BrandRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => [$this->requiredOrFilled(), 'string', 'max:50', new UniqueTenant('brands')],
            'description'       => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'is_active'         => 'nullable|boolean',

            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer'
        ];
    }
}
