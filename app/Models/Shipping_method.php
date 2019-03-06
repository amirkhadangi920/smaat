<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;

class Shipping_method extends Model
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
        'name' , 'description' , 'logo' , 'cost' , 'minimum'  , 'is_active'
    ];


    /**
     * Get all the orders of the shipping method
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
