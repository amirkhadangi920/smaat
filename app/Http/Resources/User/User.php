<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'link'              => "/api/v1/user/{$this->id}",
            'fullname'          => $this->full_name,
            'phones'            => $this->phones,
            'email'             => $this->email,
            'avatar'            => $this->avatar,
            'address'           => $this->address,
            $this->mergeWhen( $request->user, [

                'social_links'      => $this->social_links,
                'postal_code'       => $this->postal_code,
                'national_code'     => $this->national_code,
                'purchase_counts'   => $this->purchase_counts,
                'total_payments'    => $this->total_payments,
                'last_purchase'     => $this->last_purchase,
            ])
        ];
    }
}
