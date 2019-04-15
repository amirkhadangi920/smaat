<?php

namespace App\Http\Resources\Spec;

use Illuminate\Http\Resources\Json\JsonResource;

class Spec extends JsonResource
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
            'link'              => "/api/v1/spec/{$this->id}",
            'title'             => $this->title,
            'description'       => $this->description,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'category'          => $this->whenLoaded('category', function () {
                return [
                    'link'  => "/api/v1/category/{$this->category->slug}",
                    'title' => $this->category->title
                ];
            }),
            'headers'          => $this->whenLoaded('headers', function () {
                return $this->headers->map( function ( $header ) {
                    return [
                        'id'    => $header->id,
                        'link'  => "/api/v1/spec_header/{$header->id}",
                        'title' => $header->title,
                        'description' => $header->description,
                        'rows'  => $this->when( $header->rows->isNotEmpty() , function () use ($header) {
                            return $header->rows->map( function ( $row ) {
                                return [
                                    'id'            => $row->id,
                                    'link'          => "/api/v1/spec_row/{$row->id}",
                                    'title'         => $row->title,
                                    'description'   => $row->description,
                                    'label'         => $row->label,
                                    'values'        => $row->values,
                                    'help'          => $row->help,
                                    'multiple'      => $row->multiple,
                                    'required'      => $row->required,
                                ];
                            });
                        }),
                    ];
                });
            }),
        ];
    }
}
