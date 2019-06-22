<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;

class DiscountItemRequest extends MainRequest
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
            'offer'         => 'required|integer|max:100',
            'quantity'      => 'nullable|integer|max:100000',
        ];
    }
}
