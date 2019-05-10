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
            'fullname'          => $this->first_name || $this->last_name ? $this->full_name : null,
            'first_name'        => $this->when( $request->route('user', false), $this->first_name),
            'last_name'         => $this->when( $request->route('user', false), $this->last_name),
            'phones'            => $this->phones,
            'email'             => $this->email,
            'avatar'            => $this->avatar,
            'address'           => $this->address,
            'roles'             => $this->roles->map( function($role) {

                return [
                    'id'            => $role->id,
                    'name'          => $role->name,
                    'display_name'  => $role->display_name
                ];
            }),
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            $this->mergeWhen( $request->user, [

                'social_links'      => $this->social_links,
                'postal_code'       => $this->postal_code,
                'national_code'     => $this->national_code,
                'purchase_counts'   => $this->purchase_counts,
                'total_payments'    => $this->total_payments,
                'last_purchase'     => $this->last_purchase,
                'permissions'       => $this->allPermissions()->map( function($permission) {

                    return [
                        'id'    => $permission->id,
                        'name'  => $permission->name,
                    ];
                })
            ])
        ];
    }
}
