<?php

namespace App\Http\Resources\Financial;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethod extends JsonResource
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
            'id'            => $this->id,
            'link'          => "/api/v1/shipping_method/{$this->id}",
            'name'          => $this->name,
            'description'   => $this->description,
            'logo'          => $this->logo,
            'cost'          => $this->cost,
            'minimum'       => $this->minimum,
            'is_active'     => $this->is_active,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
        ];
    }
}
