<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Feature\Color;

class ColorCollection extends ResourceCollection
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
                'trash' => Color::onlyTrashed()->count()
            ],
            'chart' => Color::create_timeline()
        ];
    }
}
