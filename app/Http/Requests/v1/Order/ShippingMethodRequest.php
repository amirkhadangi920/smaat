<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;

class ShippingMethodRequest extends FormRequest
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
            'name'              => 'required|string|max:50',
            'description'       => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'cost'              => 'required|digits_between:0,10|min:0',
            'minimum'           => 'nullable|digits_between:0,10|min:0',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'minimum' => 'حداقل مبلغ سفارش'
        ];
    }
}
