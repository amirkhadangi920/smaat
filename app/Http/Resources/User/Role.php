<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
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
            'link'              => "/api/v1/role_and_permission/{$this->id}",
            'name'              => $this->display_name,
            'description'       => $this->description,
            'permissions'       => $this->whenLoaded('permissions', function () {

                return $this->permissions->map( function ( $permission ) {

                    return [
                        'id'            => $permission->id,
                        'name'          => $permission->display_name,
                        'description'   => $permission->description,
                    ];
                });
            })
        ];
    }
}
