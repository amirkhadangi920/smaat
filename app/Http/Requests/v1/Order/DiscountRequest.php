<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;

class DiscountRequest extends MainRequest
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
            'title'                 => [$this->requiredOrFilled(), 'string', 'max:50'],
            'description'           => 'nullable|string|max:255',
            'logo'                  => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'started_at'            => [$this->requiredOrFilled(), 'date', 'date_format:Y-m-d H:i:s', 'after:' . jdate()],
            'expired_at'            => [$this->requiredOrFilled(), 'date', 'date_format:Y-m-d H:i:s', 'after:started_at'],
            'is_active'             => 'nullable|boolean',

            /* relateion */
            'categories'            => ['nullable', 'array', new ExistsTenant],
            'categories.*'          => 'required|integer'
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
            'started_at' => 'تاریخ شروع تخفیف',
            'expired_at' => 'تاریخ پایان تخفیف',
        ];
    }
}
