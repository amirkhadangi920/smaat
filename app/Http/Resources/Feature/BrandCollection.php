<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Feature\Brand;
use Morilog\Jalali\Jalalian;

class BrandCollection extends ResourceCollection
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
                'trash' => Brand::onlyTrashed()->count()
            ],
            'chart' => Brand::create_timeline()
        ];
    }
}
