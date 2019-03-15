<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'title'                 => 'required|string|max:50',
            'description'           => 'nullable|string|max:255',
            'logo'                  => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'start_at'              => 'required|date|after:now',
            'expired_at'            => 'required|date|after:start_at',
        ];
    }
}
