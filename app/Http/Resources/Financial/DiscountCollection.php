<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Discount\Discount;

class DiscountCollection extends ResourceCollection
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
                'trash' => Discount::onlyTrashed()->count()
            ],
            'chart' => Discount::create_timeline()
        ];
    }
}
