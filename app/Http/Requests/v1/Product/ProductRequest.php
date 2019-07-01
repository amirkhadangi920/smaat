<?php

namespace App\Http\Requests\v1\Product;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;
use Illuminate\Validation\Rule;

class ProductRequest extends MainRequest
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
            'name'              => [
                $this->requiredOrFilled(),
                'string',
                'max:50',
                new UniqueTenant('products', $args['id'] ?? null)
            ],
            'second_name'       => 'nullable|array',
            'second_name.*'     => 'required|string|max:50',
            'code'              => [
                'nullable',
                'string',
                'max:20',
                new UniqueTenant('products', $args['id'] ?? null)
            ],
            'description'       => 'nullable|string|max:255',
            'note'              => 'nullable|string|max:255',
            'aparat_video'      => 'nullable|url|starts_with:https://www.aparat.com/v/',
            'review'            => 'nullable|string',
            'tags'              => 'nullable|array',
            'tags.*'            => 'required|string|max:100',
            'advantages'        => 'nullable|array',
            'advantages.*'      => 'required|string|max:100',
            'disadvantages'     => 'nullable|array',
            'disadvantages.*'   => 'required|string|max:100',
            'label'             => 'nullable|integer',
            'is_active'         => 'nullable|boolean',

            /* relateion */
            'categories'        => ['nullable', 'array', new ExistsTenant],
            'categories.*'      => 'required|integer',

            'colors'            => ['nullable', 'array', new ExistsTenant],
            'colors.*'          => 'required|integer',

            'brand_id'          => ['nullable', 'integer', new ExistsTenant('brands')],
            'unit_id'           => ['nullable', 'integer', new ExistsTenant('units')],
            'label_id'          => ['nullable', 'integer', new ExistsTenant('labels')],
            
            'accessories'       => ['nullable', 'array', new ExistsTenant('products')],
            'accessories.*'     => 'required|string',

            //!
            // TODO
            // 'specs'             => ['nullable', 'array', new ExistsTenant],
            // 'specs.*'           => 'required|integer',
            
            'photos'            => 'nullable|array',
            'photos.*'          => 'array',
            'photos.*.color'    => ['nullable', 'integer', 'in_array:colors.*', new ExistsTenant('colors')],
            'photos.*.image'    => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',

            'deleted_images'    => ['nullable', 'array'],
            'deleted_images.*'  => [
                'required',
                'integer',
                Rule::exists('media', 'id')->where(function ($query) use($args) {
                    return $query->where('model_type', 'App\Models\Product\Product')
                                 ->where('model_id', $args['id'] ?? false);
                })
            ],

            // 'variations'                => 'requierd|array|min:1',
            // 'variations.*'              => 'requierd|array',
            // 'variations.*.price'        => 'requierd|integer|asd|min:0',
            // 'variations.*.inventory'    => 'nullable|integer|min:0',
            // 'variations.*.color_id'     => ['nullable', 'integer', new ExistsTenant('colors')],
            // 'variations.*.size_id'      => ['nullable', 'integer', new ExistsTenant('sizes')],
            // 'variations.*.warranty_id'  => ['nullable', 'integer', new ExistsTenant('warranties')],
        ];
    }
}
