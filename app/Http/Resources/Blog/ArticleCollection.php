<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Article;

class ArticleCollection extends ResourceCollection
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
                'trash' => Article::onlyTrashed()->count()
            ],
            'chart' => Article::create_timeline()
        ];
    }
}
