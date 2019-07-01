<?php

namespace App\Http\Requests\v1\Product;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;

class VariationRequest extends MainRequest
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
            'sales_price'       => 'required|int|digits_between:1,10',
            'inventory'         => 'nullable|int|digits_between:1,10',
            'sending_time'      => 'nullable|int|max:100',

            /* relateion */
            'color_id'          => ['nullable', 'integer', new ExistsTenant('colors')],
            'size_id'           => ['nullable', 'integer', new ExistsTenant('sizes')],
            'warranty_id'       => ['nullable', 'integer', new ExistsTenant('warranties')],
            'product_id'        => [$this->requiredOrFilled(), 'string', new ExistsTenant('products')],
        ];
    }
}
