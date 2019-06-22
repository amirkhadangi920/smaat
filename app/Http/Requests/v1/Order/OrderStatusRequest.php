<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;

class OrderStatusRequest extends MainRequest
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
            'title'         => [
                $this->requiredOrFilled(),
                'string',
                'max:50',
                new UniqueTenant('order_statuses', $args['id'] ?? null)
            ],
            'description'   => 'nullable|string|max:255',
            'color'         => [
                'nullable',
                'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
                new UniqueTenant('order_statuses', $args['id'] ?? null)
            ],
            'is_active'     => 'nullable|boolean',
        ];
    }
}
