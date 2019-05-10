<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'link'              => "/api/v1/order/{$this->id}",
            'descriptions'      => $this->descriptions,
            'destination'       => $this->destination,
            'postal_code'       => $this->postal_code,
            'offer'             => $this->offer,
            'total'             => $this->total,
            'shipping_cost'     => $this->shipping_cost,
            'final_total'       => $this->total + $this->shipping_cost - $this->offer,
            'docs'              => $this->docs,
            'auth_code'         => $this->auth_code,
            'payment_code'      => $this->payment_code,
            'datetimes'         => $this->datetimes,
            'is_accept'         => $this->is_accept,
            'paid_at'           => $this->paid_at,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'user'              => $this->whenLoaded('user', function () {
                return [
                    'id'                => $this->user->id,
                    'link'              => "/api/v1/user/{$this->user->id}",
                    'full_name'         => $this->user->full_name,
                    'phones'            => $this->user->phones,
                    'email'             => $this->user->email,
                    'avatar'            => $this->user->avatar,
                    'address'           => $this->user->address,
                    'postal_code'       => $this->user->postal_code,
                    'purchase_counts'   => $this->user->purchase_counts,
                    'total_payments'    => $this->user->total_payments,
                    'last_purchase'     => $this->user->last_purchase,
                ];
            }),
            'status'            => $this->whenLoaded('order_status', function () {
                return [
                    'id' => $this->order_status->id,
                    'link' => "/api/v1/order_status/{$this->order_status->id}",
                    'title' => $this->order_status->title,
                    'color' => $this->order_status->color,
                    'description' => $this->order_status->description
                ];
            }),
            'method'            => $this->whenLoaded('shipping_method', function () {
                return [
                    'id' => $this->shipping_method->id,
                    'link' => "/api/v1/shipping_method/{$this->shipping_method->id}",
                    'name' => $this->shipping_method->name,
                    'description' => $this->shipping_method->description,
                    'logo' => $this->shipping_method->logo,
                    'cost' => $this->shipping_method->cost,
                    'minimum' => $this->shipping_method->minimum,
                ];
            }),
            'promocode'         => $this->whenLoaded('promocode', function () {
                return [
                    'id'            => $this->promocode->id,
                    'link'          => "/api/v1/promocode/{$this->promocode->id}",
                    'code'          => $this->promocode->code,
                    'value'         => $this->promocode->value,
                    'min_total'     => $this->promocode->min_total,
                    'reward_type'   => $this->promocode->reward_type,
                    'expired_at'    => $this->promocode->expired_at,
                ];
            }),
            'items'             => $this->whenLoaded('items', function () {
                return $this->items->map( function ( $item ) {
                    return [
                        'id'                => $item->id,
                        'link'              => "/api/v1/product/{$item->variation->product->slug}",
                        'name'              => $item->variation->product->name ?? null,
                        'code'              => $item->variation->product->code ?? null,
                        'photos'            => $item->variation->product->photos ?? null,
                        'label'             => $item->variation->product->label ?? null,
                        'inventory'         => $item->variation->inventory ?? null,
                        'sending_time'      => $item->variation->sending_time ?? null,
                        'price'             => $item->offer ?? $item->variation->sales_price ?? null,
                        'offer'             => $item->offer,
                        'count'             => $item->count,
                        'description'       => $item->description,
                        'create_time'       => $item->getOriginal('created_at'),
                        'last_update_time'  => $item->getOriginal('updated_at'),
                        'unit'              => $this->when($item->variation->product->unit ?? false, $item->variation->product->unit->title),
                        'color'             => $this->when($item->variation->color ?? false, function () use ($item) {
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
