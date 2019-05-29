<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use SearchableTrait;

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
     * Searchable rules.
     * 
     * Columns and their priority in search results.
     * Columns with higher values are more important.
     * Columns with equal values have equal importance.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'code' => 8,
            'longitude‎' => 5,
            'latitude‎' => 5,
        ],
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
