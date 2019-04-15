<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Feature\Unit;

class UnitCollection extends ResourceCollection
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
                'trash' => Unit::onlyTrashed()->count()
            ],
            'chart' => Unit::create_timeline()
        ];
    }
}
