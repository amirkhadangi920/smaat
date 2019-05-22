<?php

namespace App\Http\Requests\v1\Article;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueTenant;
use App\Rules\ExistsTenant;

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
        $rules = [
            'title'         => ['required', 'string', 'max:50', new UniqueTenant('articles')],
            'description'   => 'nullable|string|max:255',
            'body'          => 'required|string',
            'image'         => 'required|image|mimes:jpeg,jpg,png,gif|max:1024',
            'reading_time'  => 'nullable|digits_between:1,2',
            'is_active'     => 'nullable|boolean',
            
            /* relateion */
            'subjects'      => ['nullable', 'array', new ExistsTenant],
            'subjects.*'    => 'required|integer',
            
            'keywords'      => 'nullable|array',
            'keywords.*'    => 'required|string|max:100',
        ];

        if (request()->method() === 'PUT')
            $rules['image'] = 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024';

        return $rules;
    }
}
 
 