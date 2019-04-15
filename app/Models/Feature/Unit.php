<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group\Category;
use App\Models\Product\Product;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreateTimeline;

class Unit extends Model implements AuditableContract
{
    use SoftDeletes, Auditable ,Filterable, CreateTimeline;

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
