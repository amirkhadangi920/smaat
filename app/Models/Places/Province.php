<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
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
        'name'
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
     * Get the country of province
     */
    public function country ()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get All of the cities is in the province
     */
    public function cities ()
    {
        return $this->hasMany(City::class);
    }
}
