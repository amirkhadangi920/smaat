<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\JsonResource;

class Discount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'                => $this->id,
            'link'              => "/api/v1/discount/{$this->slug}",
            'description'       => $this->description,
            'logo'              => $this->logo,
            'started_at'        => $this->start_at,
            'expired_at'        => $this->expired_at,
            'categories'        => $this->categories->map( function ( $category ) {
                
                return [
                    'id'    => $category->id,
                    'brand_link'  => "/api/v1/category/{$category->slug}",
                    'title' => $category->title,
                ];
            }),
            'items'             => $this->whenLoaded('items', function () {
                return $this->items->map( function ( $item ) {
                    return [
                        'id'            => $item->id,
                        'link'          => "/api/v1/product/{$item->variation->product->slug}",
                        'name'          => $item->variation->product->name ?? null,
                        'code'          => $item->variation->product->code ?? null,
                        'photos'        => $item->variation->product->photos ?? null,
                        'label'         => $item->variation->product->label ?? null,
                        'inventory'     => $item->variation->inventory ?? null,
                        'sending_time'  => $item->variation->sending_time ?? null,
                        'offer'         => $item->offer,
                        'quantity'      => $item->quantity,
                        'sold_count'    => $item->sold_count,
                        'color'         => $this->when($item->variation->color ?? false, function () use ($item) {
                            return [
                                'id' => $item->variation->color->id,
                                'link' => "/api/v1/color/{$item->variation->color->id}",
                                'name' => $item->variation->color->name,
                                'code' => $item->variation->color->code,
                            ];
                        }),
                        'warranty'      => $this->when($item->variation->warranty ?? false, function () use ($item) {
                            return [
                                'id' => $item->variation->warranty->id,
                                'link' => "/api/v1/warranty/{$item->variation->warranty->id}",
                                'title' => $item->variation->warranty->title,
                                'description' => $item->variation->warranty->description,
                                'logo' => $item->variation->warranty->logo,
                                'expire' => $item->variation->warranty->expire,
                            ];
                        }),
                        'size'          => $this->when($item->variation->size ?? false, function () use ($item) {
                            return [
                                'id' => $item->variation->size->id,
                                'link' => "/api/v1/size/{$item->variation->size->id}",
                                'name' => $item->variation->size->name,
                            ];
                        }),
                    ];
                });
            }),
        ];
    }
}
