<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Financial\Order;

class OrderCollection extends ResourceCollection
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
                'trash' => Order::onlyTrashed()->count()
            ],
            'chart' => Order::create_timeline()
        ];
    }
}
