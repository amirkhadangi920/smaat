<?php

namespace App\Models\Promocode;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;

class Promocode extends Model
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

        'code',
        'value',
        'min_total',
        'reward_type',
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
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
    