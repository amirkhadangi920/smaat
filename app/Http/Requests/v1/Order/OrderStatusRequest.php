<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;

class OrderStatusRequest extends FormRequest
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
            'title'         => ['required', 'string', 'max:50', new UniqueTenant('order_statues')],
            'description'   => 'nullable|string|max:255',
            'color'         => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', new UniqueTenant('order_statues')],
            'is_active'     => 'nullable|boolean',
        ];
    }
}
