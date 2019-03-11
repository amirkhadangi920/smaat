<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'descriptions'      => 'nullable|array',
            'destination'       => 'nullable|string|max:255',
            'postal_code'       => 'nullable|digit:10|max:10',  
            'offer'             => 'nullable|digits_between:0,100000',
            'total'             => 'nullable|digits_between:100000,10000000',
            'datetimes'         => 'nullable|array|string',
            'docs'              => 'nullable|array',
            'checkout'          => 'boolean',
            'type'              => 'required|digits_between:0,127',

            /**
             * relateion 
             */
            'users.*'           => 'required|array|exists:users,id',
            'order_status.*'    => 'required|integer|exists:order_statuses,id',
            'promocodes.*'      => 'required|integer|exists:promocodes,id',
            'shippin_methods.*' => 'required|integer|exists:shippin_methods,id',
            // 'cities.*'           => 'required|array|exists:city,id',
        ];
    }
}