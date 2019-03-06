<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group\Category;
use App\Models\Product\Product;

class Unit extends Model
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
        'title',
        'description'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

     /****************************************
     **             Relations
     ***************************************/
    
    /**
     * Get the category that owned unit
     */
    public function categories ()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all the products of the unit.
     */
    public function products ()
    {
        return $this->hasMany(Product::class);
    }
}
