<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class ShippingMethodTranslation extends Model
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
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
