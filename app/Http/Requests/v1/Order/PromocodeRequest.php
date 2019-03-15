<?php

namespace App\Http\Requests\v1\Order;

use Illuminate\Foundation\Http\FormRequest;

class PromocodeRequest extends FormRequest
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
            'code'                  => 'required|string|max:50',
            'value'                 => 'required|integer|digits_between:1,10',
            'min_total'             => 'nullable|integer|digits_between:1,10',
            'expired_at'            => 'required|date|after:now',

            /* relations */
            'categories'            => 'nullable|array',  
            'categories.*'          => 'required|integer|exists:categories,id',
            
            'variations'            => 'nullable|array',  
            'variations.*'          => 'required|string|exists:variations,id',
            
            'users'                 => 'nullable|array',  
            'users.*'               => 'required|string|exists:users,id',
        ];
    }
}
