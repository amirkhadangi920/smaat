<?php

namespace App\Models\Places;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;
use Nicolaslopezj\Searchable\SearchableTrait;

class City extends Model
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
        'province_id', 
        'longitude‎',
        'latitude‎',
        'name',
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

    /**
     * Get all of the orders of city.
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }
}
