<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Group\Category;

class CategoryCollection extends ResourceCollection
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
                'total' => Category::count(),
                'trash' => Category::onlyTrashed()->count()
            ],
            'chart' => Category::create_timeline()
        ];
    }
}
