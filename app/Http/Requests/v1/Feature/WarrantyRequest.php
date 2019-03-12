<?php

namespace App\Http\Requests\v1\Feature;

use Illuminate\Foundation\Http\FormRequest;

class WarrantyRequest extends FormRequest
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
            'title'         => 'required|string|max:50',
            'description'   => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'expire'        => 'required|string'
        ];
    }
}
