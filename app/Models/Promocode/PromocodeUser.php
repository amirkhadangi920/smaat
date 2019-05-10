<?php

namespace App\Models\Promocode;

use Illuminate\Database\Eloquent\Model;

class PromocodeUser extends Model
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

        'is_used',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_used'  => 'boolean'
    ];
}
