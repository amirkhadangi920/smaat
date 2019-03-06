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
     * Get all of the tags for the post.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'featureable');
    }

    /**
     * Get all the products of the unit.
     */
    public function products ()
    {
        return $this->hasMany(Product::class);
    }
}
