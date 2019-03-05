<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;

class Discount extends Model
{
    
    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'logo',
        'type',
        'status',
        'start_at',
        'expired_at'
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
    * Get all of the discount's user.
    */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * get the all discount item that owned the discount
     */
    public function discount_item ()
    {
        return $this->hasMany(DiscountItem::class);
    }

    /**
     * get the all Order that owned the discount
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
