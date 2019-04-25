<?php

namespace App;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Laratrust\Models\LaratrustRole;
use EloquentFilter\Filterable;
use App\Helpers\HasTenant;

class Role extends LaratrustRole implements AuditableContract
{
    use Auditable, Filterable, HasTenant;

    /****************************************
     **             Attributes
     ***************************************/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}
