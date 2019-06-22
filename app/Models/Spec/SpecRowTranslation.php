<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;

class SpecRowTranslation extends Model
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
        'prefix',
        'postfix',
        'description',
        'help',
    ];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
