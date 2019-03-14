<?php

namespace App\Http\Requests\v1\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'         => 'required|string|max:50',
            'description'   => 'nullable|string|max:255',
            'body'          => 'required|string',
            'image'         => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            'reading_time'  => 'nullable|digit_between:1,2',
            
            /* relateion */
            'subjects'      => 'nullable|array',
            'subjects.*'    => 'required|integer|exists:subjects,id',
            
            'keywords'      => 'nullable|array',
            'keywords.*'    => 'required|string|max:100',
        ];
    }
}
 
 