<?php

namespace App\Http\Requests\v1\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'              => 'required|string|max:50',
            'second_name'       => 'nullable|string|max:50',
            'code'              => 'nullable|string|max:20',
            'description'       => 'nullable|string|max:255',
            'note'              => 'nullable|string|max:255',
            'aparat_video'      => 'nullable|url',
            'status'            => 'required|boolean',
            'review'            => 'nullable|string',
            'keywords'          => 'nullable|array',  
            'keywords.*'        => 'required|string|max:100',  
            'photos'            => 'required|array|min:1',
            'photos.*'          => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            'advantages'        => 'nullable|array',
            'advantages.*'      => 'required|string|max:100',
            'disadvantages'     => 'nullable|array',
            'disadvantages.*'   => 'required|string|max:100',
            'label'             => 'nullable|integer',

            /* relateion */
            'category_id'       => 'nullable|integer|exists:categories,id',
            'brand_id'          => 'nullable|integer|exists:brands,id',
            'unit_id'           => 'nullable|integer|exists:units,id',
            'specs.*'           => 'required|integer|exists:speces,id',  
            'specs.*'           => 'required|integer|exists:speces,id',  
            'accessories'       => 'nullable|array',  
            'accessories.*'     => 'required|string|exists:products,id',

            'variations'                => 'requierd|array|min:1',
            'variations.*'              => 'requierd|array',
            'variations.*.price'        => 'requierd|integer|asd|min:0',
            'variations.*.inventory'    => 'nullable|integer|min:0',
            'variations.*.color_id'     => 'nullable|integer|exists:colors,id',
            'variations.*.size_id'      => 'nullable|integer|exists:sizes,id',
            'variations.*.warranty_id'  => 'nullable|integer|exists:warranties,id',
        ];
    }
}
