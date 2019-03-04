<?php

namespace App\Models\Promocode;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
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

        'code',
        'value',
        'min_total',
        'reward_type',
        'expired_at'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the promocode that owned user.
     */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Get the all promocode user that owned promocode.
     */
    public function promocode_users ()
    {
        return $this->hasMany(PromocodeUser::class);
    }
}
    