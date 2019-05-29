<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;

class SpecDefaultTranslation extends Model
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
        'value',
    ];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
