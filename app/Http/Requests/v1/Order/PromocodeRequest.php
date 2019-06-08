<?php

namespace App\Http\Requests\v1\Order;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;
use App\Rules\UniqueTenant;

class PromocodeRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'                  => [$this->requiredOrFilled(), 'string', 'max:50', new UniqueTenant('promocodes', null, false)],
            'value'                 => [$this->requiredOrFilled(), 'integer', 'min:1', 'max:99'],
            'min_total'             => 'nullable|integer|digits_between:1,10',
            'expired_at'            => [$this->requiredOrFilled(), 'date', 'after:now'],

            /* relations */
            'categories'            => ['nullable', 'array', new ExistsTenant],
            'categories.*'          => 'required|integer',
            
            'variations'            => ['nullable', 'array', new ExistsTenant],
            'variations.*'          => 'required|string',
            
            'users'                 => ['nullable', 'array', new ExistsTenant],
            'users.*'               => 'required|string',
        ];
    }
}
