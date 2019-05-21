<?php

namespace App\Models\Group;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Spatie\Tags\HasTags;
use App\Models\Feature\{
    Brand,
    Color,
    Size,
    Warranty,
    Unit
};
use App\Models\Spec\Spec;
use App\Models\Product\Product;
use App\Models\Discount\Discount;
use App\Models\Financial\OrderPoint;
use App\Traits\MultiLevel;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;

class Category extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, HasTags, MultiLevel;
    use CreateTimeline, HasTenant, CreatorRelationship;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'description',
        'logo',
        'scoring_feilds',
        'is_active'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'parent_id',
        'title',
        'description',
        'logo',
        'scoring_feilds',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scoring_feilds'    => 'array',
        'logo'              => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'parent_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'scoring_feilds'
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
     * Get all the products that owned by the category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the colors that are assigned this category.
     */
    public function colors()
    {
        return $this->morphedByMany(Color::class, 'featureable');
    }

    /**
     * Get all of the colors that are assigned this category.
     */
    public function sizes()
    {
        return $this->morphedByMany(Size::class, 'featureable');
    }

    /**
     * Get all of the colors that are assigned this category.
     */
    public function brands()
    {
        return $this->morphedByMany(Brand::class, 'featureable');
    }

    /**
     * Get all of the colors that are assigned this category.
     */
    public function units()
    {
        return $this->morphedByMany(Unit::class, 'featureable');
    }

    /**
     * Get all of the colors that are assigned this category.
     */
    public function warranties()
    {
        return $this->morphedByMany(Warranty::class, 'featureable');
    }

    /**
     * Relation to orderpoint model with orderable
     * 
     * @return OrderPoint Model
     */
    
    public function order_points()
    {
        return $this->morphMany(OrderPoint::class, 'orderable');
    }

    /**
     * Get all the specification table that owned by the category
     */
    public function spec()
    {
        return $this->hasOne(Spec::class);
    }

    /**
     * Get all the child categories that owned by the category
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    /**
     * return parent category that can have many childs
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all the promocodes that owned the category & adverb
     */
    public function promocodes()
    {
        return $this->belongsToMany(Promocode::class);
    }
    

    /**
     * Get all the discounts that owned the category & adverb
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }
}