<?php

namespace App\Http\Requests\v1\Opinion;

use App\Http\Requests\v1\MainRequest;
use App\Rules\ExistsTenant;

class CommentRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message'       => 'required|string',

            /* relateion */
            'parent_id'     => ['nullable', 'integer', new ExistsTenant('comments')],
            'article_id'    => ['required', 'string', new ExistsTenant('articles')],
        ];
    }
}
