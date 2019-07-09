<?php

namespace App;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use App\Helpers\HasTenant;
use App\Models\Places\City;

class UserAddress extends Model implements AuditableContract
{
    use Filterable, SoftDeletes, Auditable, SpatialTrait, HasTenant;

    /****************************************
     **             Attributes
     ***************************************/

    protected static $jalali_time = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'full_name',
        'phone_number',
        'type',
        'address',
        'postal_code',
        'coordinates'
    ];

    /**
     * The attributes that store as spatial field in storage.
     *
     * @var array
     */
    protected $spatialFields = [
        'coordinates',
    ];
    
    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'city_id',
        'type',
        'adress',
        'postal_code',
        'coordinates',
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
     * Get the user that owned this phone number
     */
    public function user()
    {
        return $this->belongsTo(App\User::class);
    }

    /**
     * Get the user that owned this phone number
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}