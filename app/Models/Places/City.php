<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;

class City extends Model
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
        'province_id', 
        'longitude‎',
        'latitude‎',
        'name',
        'code'
    ];

    /**
     * Indicates the model shouldn't be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /****************************************
     **            Relationships
     ***************************************/
    
    /**
     * Get the province that owns the city.
     */
    public function province ()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get all of the users for the city.
     */
    public function users ()
    {
        return $this->hasMany(\App\User::class);
    }
}
