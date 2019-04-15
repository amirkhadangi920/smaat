<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Resources\Json\JsonResource;

class Color extends JsonResource
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
            'link'              => "/api/v1/color/{$this->id}",
            'name'              => $this->name,
            'code'              => $this->code,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'categories'        => $this->categories->map( function ( $category ) {
                
                return [
                    'id'    => $category->id,
                    'link'  => "/api/v1/category/{$category->slug}",
                    'title' => $category->title,
                ];
            })
        ];
    }
}
