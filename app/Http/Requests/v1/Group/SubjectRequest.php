<?php

namespace App\Http\Requests\v1\Group;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => ['required', 'string', 'max:50', new UniqueTenant('subjects')],
            'description'       => 'nullable|string|min:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'is_active'         => 'nullable|boolean',

            /* relateion */
            'parent_id'         => ['nullable', 'integer', new ExistsTenant('subjects')],

            'keywords'          => 'nullable|array',
            'keywords.*'        => 'required|string|max:100',
        ];
    }
}