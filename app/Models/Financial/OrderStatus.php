<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
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
     * Get all the orders of the order status
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
