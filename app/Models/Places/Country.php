<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
     * Get all the provinces that place in the country
     */
    public function provinces ()
    {
        return $this->hasMany(Province::class);
    }

    /**
     * Get all the cities that place in the country
     */
    public function cities ()
    {
        return $this->hasManyThrough(City::class, Province::class);
    }
}
