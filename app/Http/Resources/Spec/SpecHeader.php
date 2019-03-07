<?php

namespace App\Http\Resources\Spec;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecHeader extends JsonResource
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
            'link'              => "/api/v1/spec_header/{$this->id}",
            'title'             => $this->title,
            'description'       => $this->description,
            'spec'              => $this->whenLoaded('spec', function () {
                return [
                    'id' => $this->spec->id,
                    'link'  => "/api/v1/spec/{$this->spec->id}",
                    'title' => $this->spec->title,
                    'description' => $this->spec->description
                ];
            }),
            'rows'              => $this->whenLoaded( 'rows' , function () {
                return $this->rows->map( function ( $row ) {
                    return [
                        'id'            => $row->id,
                        'link'          => "/api/v1/spec_row/{$row->id}",
                        'title'         => $row->title,
                        'description'   => $row->description,
                        'label'         => $this->label,
                        'values'        => $row->values,
                        'help'          => $row->help,
                        'multiple'      => $this->multiple,
                        'required'      => $this->required,
                    ];
                });
            }),
        ];
    }
}
