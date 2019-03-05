<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;

class OrderPoint extends Model
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

    /****************************************
    **             Relations
    ***************************************/


    /**
     * Relation morph
     *
     */
    public function orderable ()
    {
        return $this->morphTo();
    }
}
