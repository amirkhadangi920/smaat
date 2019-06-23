<?php

namespace App\Http\Requests\v1\Group;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

class SubjectRequest extends MainRequest
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
                new UniqueTenant('subjects', $args['id'] ?? null)
            ],
            'description'       => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'is_active'         => 'nullable|boolean',

            /* relateion */
            'parent_id'         => ['nullable', 'integer', new ExistsTenant('subjects')],

            'keywords'          => 'nullable|array',
            'keywords.*'        => 'required|string|max:100',
        ];
    }
}