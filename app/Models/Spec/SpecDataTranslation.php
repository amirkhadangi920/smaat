<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;

class SpecDataTranslation extends Model
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
        'data'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
