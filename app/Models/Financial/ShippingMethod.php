<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;

class ShippingMethod extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, CreateTimeline;
    
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
        'description',
        'logo',
        'cost',
        'minimum',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'logo'              => 'array'
    ];



    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get all the orders of the shipping method
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
