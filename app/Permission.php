<?php

namespace App;

use Laratrust\Models\LaratrustPermission;
use Dimsav\Translatable\Translatable;

class Permission extends LaratrustPermission
{
    use Translatable;

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
        // 'display_name',
        // 'description'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'display_name',
        'description',
    ];
}
