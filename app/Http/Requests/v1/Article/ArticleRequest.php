<?php

namespace App\Http\Requests\v1\Article;

use App\Http\Requests\v1\MainRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

class ArticleRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($args, $method)
    {
        $this->method = $method;

        $rules = [
            'title'         => [
                $this->requiredOrFilled(),
                'string',
                'max:100', 
                new UniqueTenant('articles', $args['id'] ?? null)
            ],
            'description'   => 'nullable|string|max:255',
            'body'          => [$this->requiredOrFilled(), 'string'],
            'image'         => [
                $method === 'CREATE' ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:1024'
            ],
            'reading_time'  => 'nullable|digits_between:1,2',
            'is_active'     => 'nullable|boolean',
            
            /* relateion */
            'subjects'      => ['nullable', 'array', new ExistsTenant],
            'subjects.*'    => 'required|integer',
            
            'keywords'      => 'nullable|array',
            'keywords.*'    => 'required|string|max:100',
        ];

        return $rules;
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'body' => 'متن مقاله',
            'image' => 'تصویر مقاله'
        ];
    }
}
