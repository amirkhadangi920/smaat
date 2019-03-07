<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Resources\Json\JsonResource;

class Brand extends JsonResource
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
            'link'              => "/api/v1/brand/{$this->slug}",
            'logo'              => $this->logo,
            'name'              => $this->name,
            'description'       => $this->description,
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
