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
            'id'                => $this->id,
            'link'              => "/api/v1/role/{$this->id}",
            'name'              => $this->display_name,
            'description'       => $this->description,
            'permissions_count' => $this->permissions_count,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'permissions'       => $this->whenLoaded('permissions', function () use($request) {

                if ( $request->route('role') )
                {
                    return $this->permissions->map( function ( $permission ) {
    
                        return [
                            'id'            => $permission->id,
                            'name'          => $permission->display_name,
                            'description'   => $permission->description,
                        ];
                    });
                }
                else
                {
                    return $this->permissions->map( function ( $permission ) {
    
                        return $permission->id;
                    });
                }
            })
        ];
    }
}
