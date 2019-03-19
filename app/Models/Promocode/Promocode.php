<?php

namespace App\Models\Promocode;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Financial\Order;
use App\Models\Group\Category;
use App\Models\Product\Variation;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable;

    /****************************************
     **             Attributes
     ***************************************/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'value',
        'min_total',
        'max',
        'quantity',
        'reward_type',
        'expired_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'expired_at'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the all promocode user that owned promocode.
     */
    public function promocode_user()
    {
        return $this->hasMany(PromocodeUser::class);
    }

    /**
     * Get the all orders that owned promocode.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the categories that owned the promocode & adverb
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get all the users that owned the promocode & adverb
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class);
    }

    /**
     * Get all the variations that owned the promocode & adverb
     */
    public function variations ()
    {
        return $this->belongsToMany(Variation::class);
    }


    /****************************************
     **               Methods
     ***************************************/
}