<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'link'              => "/api/v1/product/{$this->slug}",
            'name'              => $this->name,
            'description'       => $this->description,
            'aparat_video'      => "https://www.aparat.com/v/{$this->aparat_video}",
            'photos'            => $this->photos,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'votes'             => [
                'likes' => $this->likesCount,
                'dislikes' => $this->dislikesCount,
            ],
            $this->mergeWhen($this->second_name, [

                'second_name'       => $this->second_name,
                'code'              => $this->code,
                'review'            => $this->review,
                'keywords'          => $this->keywords,
                'advantages'        => $this->advantages,
                'disadvantages'     => $this->disadvantages,
            ]),
            'label'             => $this->label,
            'views_count'       => $this->views_count,
            'tags'              => $this->whenLoaded('tags', function () {
                return $this->tags->map( function ($tag) {
                    return [
                        'link' => "/api/v1/tag/{$tag->slug}",
                        'name' => $tag->name,
                    ];
                });
            }),
            'brand'             => $this->whenLoaded('brand', function () {
                return [
                    'link'  => "/api/v1/brand/{$this->brand->slug}",
                    'name' => $this->brand->name
                ];
            }),
            'category'          => $this->whenLoaded('category', function () {
                return [
                    'link'  => "/api/v1/category/{$this->category->slug}",
                    'title' => $this->category->title
                ];
            }),
            'unit'              => $this->whenLoaded('unit', function () {
                return [
                    'link'  => "/api/v1/unit/{$this->unit->id}",
                    'title' => $this->unit->title
                ];
            }),
            'accessories'       => $this->whenLoaded('accessories', function () {
                return $this->accessories->map( function ( $accessory ) {
                    return [
                        'id'        => $accessory->id,
                        'link'      => "/api/v1/product/{$accessory->id}",
                        'name'      => $accessory->name,
                        'label'     => $accessory->label,
                        'photos'    => $accessory->photos,
                    ];
                });
            }),
            'variations'        => $this->whenLoaded('variations', function () {
                return $this->variations->map( function ( $variation ) {
                    return [
                        'id'    => $variation->id,
                        'link'  => "/api/v1/variation/{$variation->id}",
                        'price' => $variation->sales_price,
                        'inventory' => $variation->inventory,
                        'sending_time' => $variation->sending_time,
                        'color' => $this->when( $variation->color , function () use ($variation) {
                            return [
                                'id'    => $variation->color->id,
                                'link'  => "/api/v1/color/{$variation->color->id}",
                                'name'  => $variation->color->name,
                                'code'  => $variation->color->code,
                            ];
                        }),
                        'size' => $this->when( $variation->size , function () use ($variation) {
                            return [
                                'id'    => $variation->size->id,
                                'link'  => "/api/v1/size/{$variation->size->id}",
                                'name'  => $variation->size->name,
                            ];
                        }),
                        'warranty' => $this->when( $variation->warranty , function () use ($variation) {
                            return [
                                'id'        => $variation->warranty->id,
                                'link'      => "/api/v1/warranty/{$variation->warranty->id}",
                                'title'     => $variation->warranty->title,
                                'logo'      => $variation->warranty->logo,
                                'expire'    => $variation->warranty->expire,
                            ];
                        }),
                    ];
                });
            }),
            'spec'     => $this->when( $this->spec->headers ?? false, function () {
                
                return $this->spec->headers->map( function ( $header ) {
                    return [
                        'id' => $header->id,
                        'link' => "/api/v1/spec_header/{$header->id}",
                        'title' => $header->title,
                        'description' => $header->description,
                        'rows' => $this->when( $header->rows ?? false, function () use ($header) {

                            return $header->rows->map( function ( $row ) {
                                if ( $row->data->data ?? false )
                                {
                                    return [
                                        'id' => $row->id,
                                        'link' => "/api/v1/spec_row/{$row->id}",
                                        'title' => $row->title,
                                        'label' => $row->label,
                                        'values' => $row->values,
                                        'help' => $row->help,
                                        'multiple' => $row->multiple,
                                        'data' => $row->data->data
                                    ];
                                }
                            })->filter( function ($data) {
                                return $data;
                            });
                        }),
                    ];
                });
            }),
        ];
    }
}
