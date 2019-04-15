<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use EloquentFilter\Filterable;
use App\Models\Group\Category;
use App\Models\Product\Product;
use App\Helpers\CreateTimeline;

class Brand extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, CreateTimeline;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo',
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo' => 'array'
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
     * Get all the products of the brand.
     */
    public function products ()
    {
        return $this->hasMany(Product::class);
    }


    /****************************************
     **              Methods
     ***************************************/
}
