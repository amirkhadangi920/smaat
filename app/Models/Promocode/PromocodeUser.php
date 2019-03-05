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
        'used_at' 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'used_at'    => 'boolean',
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
    * Get the promocode user that owned user.
    */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
    * Get the promocode that owned  promocode user.
    */
    public function promocode ()
    {
        return $this->belongsTo(Promocode::class);
    }
}
 
        