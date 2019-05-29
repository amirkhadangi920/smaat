<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Province extends Model
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
        'name'
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
