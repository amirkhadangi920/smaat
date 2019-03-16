<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
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
