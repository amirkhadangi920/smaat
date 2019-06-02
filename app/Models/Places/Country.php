<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Country extends Model
{
    use SearchableTrait, SpatialTrait;

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
        'code',
        'coordinates'
    ];

    /**
     * The attributes that store as spatial field in storage.
     *
     * @var array
     */
    protected $spatialFields = [
        'coordinates',
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
