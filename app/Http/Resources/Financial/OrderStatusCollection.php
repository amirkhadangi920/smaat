<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Financial\OrderStatus;

class OrderStatusCollection extends ResourceCollection
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
                'total' => OrderStatus::count(),
                'trash' => OrderStatus::onlyTrashed()->count(),
            ],
            'chart' => OrderStatus::create_timeline()
        ];   
    }
}
