<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Financial\ShippingMethod;

class ShippingMethodCollection extends ResourceCollection
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
                'trash' => ShippingMethod::onlyTrashed()->count()
            ],
            'chart' => ShippingMethod::create_timeline()
        ];
    }
}
