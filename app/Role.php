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
        'description',
        'is_active'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'name',
        'display_name',
        'description',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];
}
