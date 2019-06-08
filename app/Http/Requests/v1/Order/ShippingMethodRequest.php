<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;

class ShippingMethodRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => [$this->requiredOrFilled(), 'string', 'max:50', new UniqueTenant('shipping_methods')],
            'description'       => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'cost'              => [$this->requiredOrFilled(), 'digits_between:0,10', 'min:0'],
            'minimum'           => 'nullable|digits_between:0,10|min:0',
            'is_active'         => 'nullable|boolean',
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
