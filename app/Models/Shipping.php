<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
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
        'info' , 'logo' , 'cost' , 'minimum'  , 'is_active'
    ];
}
