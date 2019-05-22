<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            /* User information */
            'first_name'            => 'required|string|max:20',
            'last_name'             => 'required|string|max:30',
            'phone'                 => ['required', 'string', 'regex:/09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}/'],
            'national_code'         => ['required', 'regex:/^\d{10}$/'],
            
            /* Order information */
            'city_id'               => ['required', 'integer', new ExistsTenant('cities')],
            'shippin_method_id'     => ['required', 'integer', new ExistsTenant('shippin_methods')],
            'description'           => 'nullable|string|max:255',
            'destination'           => 'required|string|max:255',
            'postal_code'           => ['required', 'regex:/^\d{10}$/'],
        ];
    }
}
