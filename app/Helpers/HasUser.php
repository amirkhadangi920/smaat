<?php

namespace App\Helpers;

Trait HasUser
{
    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function createNewModel($data)
    {
        if ( !auth()->check() )
            return abort(401);

        return auth()->user()->{$this->rel_from_user}()->create( $data );
    }
}
