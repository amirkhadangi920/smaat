<?php

namespace App\Http\Requests\v1\Group;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required|string|min:50',
            'description'       => 'nullable|string|min:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
        ];
    }
}
