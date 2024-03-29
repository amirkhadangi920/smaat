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
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use App\Helpers\MediaConversionsTrait;

class Category extends Model implements AuditableContract, HasMedia
{
    use SoftDeletes, Auditable, HasTags, MultiLevel;
    use CreateTimeline, HasTenant, CreatorRelationship, SoftCascadeTrait;
    use Translatable, SearchableTrait;
    use HasMediaTrait, MediaConversionsTrait;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'childs'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'icon',
        'is_active'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'slug',
        'title',
        'description',
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
            'category_translations.title' => 10,
            'category_translations.description' => 5,
        ],
        'joins' => [
            'category_translations' => ['categories.id','category_translations.category_id'],
        ],
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
        'scoring_feilds',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean'
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
        return $this->belongsToMany(Product::class, 'product_category');
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
     * Get all the scoring fields of this category
     */
    public function scoring_fields()
    {
        return $this->hasMany(ScoringField::class);
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
        return $this->belongsToMany(Spec::class, 'spec_category');
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

    /**
     * Get the media field of the model
     */
    public function logo()
    {
        return $this->morphMany(config('medialibrary.media_model'), 'model');
    }


    /****************************************
     **              Methods
     ***************************************/
}