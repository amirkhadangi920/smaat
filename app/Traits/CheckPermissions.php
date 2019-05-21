<?php

namespace App\Traits;

trait CheckPermissions
{
    /**
     * Check the user permision to access a request,
     * abort 403 status code or access deny if hadn't
     *
     * @param string $permission
     * @return void
     */
    public function checkPermission(string $permission)
    {
        if ( !auth()->check() || !auth()->user()->can($permission) )
            return false;

        else
            return true;
    }
}