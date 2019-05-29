<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionTranslation extends Model
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
        'display_name',
        'description'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
