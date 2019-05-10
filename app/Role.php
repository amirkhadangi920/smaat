<?php

namespace App;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Laratrust\Models\LaratrustRole;
use EloquentFilter\Filterable;
use App\Helpers\HasTenant;
use App\Helpers\CreateTimeline;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends LaratrustRole implements AuditableContract
{
    use SoftDeletes ,Auditable, Filterable, HasTenant, CreateTimeline;

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
