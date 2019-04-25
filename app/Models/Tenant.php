<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Traits\GenerateRandomID;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model implements AuditableContract
{
    use Auditable, SoftDeletes, GenerateRandomID;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes specifies that table has char type id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /****************************************
     **             Relations
     ***************************************/

    /**
    * Get all of the article's user.
    */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
    * Get all of the hostnames of the tenant.
    */
    public function hostnames()
    {
        return $this->hasMany(Hostname::class);
    }
}