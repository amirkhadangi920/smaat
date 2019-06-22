<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;

class OrderRequest extends MainRequest
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
            'description'       => 'nullable|string',
            'destination'       => 'nullable|string|max:255',
            'postal_code'       => 'nullable|digit:10',
            'offer'             => 'nullable|digits_between:1,10',
            'total'             => 'nullable|digits_between:1,10',
            'checkout'          => 'requierd|boolean',
            'type'              => 'required|integer|max:5',

            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            
            'users_id'          => ['required', 'string', new ExistsTenant('users')],
            'order_status_id'   => ['required', 'integer', new ExistsTenant('order_statuses')],
            'shippin_method_id' => ['nullable', 'integer', new ExistsTenant('shippin_methods')],
            'city_id'           => ['nullable', 'integer', new ExistsTenant('cities')],
        ];
    }
}