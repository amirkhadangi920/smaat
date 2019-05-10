<?php

namespace App\Http\Resources\Spec;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecRow extends JsonResource
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
            'link'              => "/api/v1/spec_row/{$this->id}",
            'title'             => $this->title,
            'description'       => $this->description,
            'label'             => $this->label,
            'values'            => $this->values,
            'help'              => $this->help,
            'multiple'          => $this->multiple,
            'required'          => $this->required,
            'header'              => $this->whenLoaded('header', function () {
                return [
                    'id' => $this->header->id,
                    'link'  => "/api/v1/spec_header/{$this->header->id}",
                    'title' => $this->header->title,
                    'description' => $this->header->description
                ];
            }),
        ];
    }
}
