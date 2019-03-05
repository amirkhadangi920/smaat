<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
