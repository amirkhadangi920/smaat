<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\JsonResource;

class Promocode extends JsonResource
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
            'link'              => "/api/v1/promocode/{$this->slug}",
            'code'              => $this->code,
            'value'             => $this->value,
            'min_total'         => $this->min_total,
            'expired_at'        => $this->expired_at,
            'categories'        => $this->whenLoaded('categories', function () {

                return $this->categories->map( function ( $category ) {
                    
                    return [
                        'id'    => $category->id,
                        'brand_link'  => "/api/v1/category/{$category->slug}",
                        'title' => $category->title,
                    ];
                });
            }),
            'users'             => $this->whenLoaded('users', function () {

                return $this->users->map( function ( $user ) {
                    
                    return [
                        'id'                => $user->id,
                        'link'              => "/api/v1/user/{$user->id}",
                        'full_name'         => $user->full_name,
                    ];
                });
            }),
            'orders'            => $this->whenLoaded('orders', function () {

                return $this->orders->map( function ( $order ) {
                    
                    return [
                        'id'                => $this->id,
                        'link'              => "/api/v1/order/{$this->id}",
                        'total'             => $this->total,
                        'offer'             => $this->offer,
                        'paid_at'           => $this->paid_at,
                        'user'              => $this->whenLoaded('user', function () {
                            return [
                                'id'                => $this->user->id,
                                'link'              => "/api/v1/user/{$this->user->id}",
                                'full_name'         => $this->user->full_name,
                            ];
                        }),
                    ];
                });
            }),
            'variations'        => $this->whenLoaded('variations', function () {

                return $this->variations->map( function ( $variation ) {
                    
                    return [
                        'id'            => $variation->id,
                        'link'          => "/api/v1/product/{$variation->product->slug}",
                        'name'          => $variation->product->name ?? null,
                        'code'          => $variation->product->code ?? null,
                        'photos'        => $variation->product->photos ?? null,
                        'label'         => $variation->product->label ?? null,
                        'inventory'     => $variation->inventory ?? null,
                        'sending_time'  => $variation->sending_time ?? null,
                        'color'         => $this->when($variation->color ?? false, function () use ($variation) {
                            return [
                                'id' => $variation->color->id,
                                'link' => "/api/v1/color/{$variation->color->id}",
                                'name' => $variation->color->name,
                                'code' => $variation->color->code,
                            ];
                        }),
                        'warranty'      => $this->when($variation->warranty ?? false, function () use ($variation) {
                            return [
                                'id' => $variation->warranty->id,
                                'link' => "/api/v1/warranty/{$variation->warranty->id}",
                                'title' => $variation->warranty->title,
                                'description' => $variation->warranty->description,
                                'logo' => $variation->warranty->logo,
                                'expire' => $variation->warranty->expire,
                            ];
                        }),
                        'size'          => $this->when($variation->size ?? false, function () use ($variation) {
                            return [
                                'id' => $variation->size->id,
                                'link' => "/api/v1/size/{$variation->size->id}",
                                'name' => $variation->size->name,
                            ];
                        }),
                    ];
                });
            })
        ];
    }
}
