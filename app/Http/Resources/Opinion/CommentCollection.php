<?php

namespace App\Http\Resources\Opinion;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Opinion\Comment;

class CommentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'trash' => Comment::onlyTrashed()->count()
            ],
            'chart' => Comment::create_timeline()
        ];
    }
}
