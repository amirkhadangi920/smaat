<?php

namespace App\Models\Product;

use Cog\Likeable\Contracts\Likeable as LikeableContract;
use Cog\Likeable\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Opinion\{ Review, QuestionAndAnswer };
use Spatie\Tags\HasTags;
use App\Models\Spec\{ SpecData, Spec };
use App\Models\Group\Category;
use App\Models\Feature\{ Brand, Unit };
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\CreatorRelationship;
use App\Helpers\HasTenant;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements AuditableContract, LikeableContract
{
    use SoftDeletes, Auditable, HasTenant, HasTags;
    use Filterable, Likeable, CreateTimeline, CreatorRelationship;
    use SoftCascadeTrait, Translatable, SearchableTrait;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'variations',
        'reviews',
        'questions',
        'spec_data'
    ];

    /**
     * The attributes specifies that table has char type id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes defines use uuid when creating
     * or auto increment integer
     *
     * @var boolean
     */
    protected static $create_uuid = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'unit_id',
        'spec_id',
        'code',
        'note',
        'aparat_video',
        'review',
        'photos',
        'is_active'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'slug',
        'name',
        'second_name',
        'description',
        'review',
        'advantages',
        'disadvantages',
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
            'product_translations.name' => 10,
            'product_translations.second_name' => 8,
            'product_translations.description' => 5,
            'product_translations.advantages' => 6,
            'product_translations.disadvantages' => 6,
            'brand_translations.name' => 7,
            'category_translations.title' => 7,
        ],
        'joins' => [
            'brand_translations' => ['products.brand_id','brand_translations.brand_id'],
            'category_translations' => ['products.category_id','category_translations.category_id'],
            'product_translations' => ['products.id','product_translations.product_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'brand_id',
        'category_id',
        'unit_id',
        'spec_id',
        'name',
        'second_name',
        'code',
        'description',
        'note',
        'aparat_video',
        'review',
        'advantages',
        'disadvantages',
        'label',
        'photos',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'photos' => 'array',
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
     * Get all the variations of the product.
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Get all of the users like some products
     */
    public function favorites()
    {
        return $this->belongsToMany(\App\User::class, 'favorites');
    }

    /**
     * Get all the reviews of the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get all the questionAndAnsers of the product.
     */
    public function questions()
    {
        return $this->hasMany(QuestionAndAnswer::class)->whereNull('question_id');
    }
    
    /**
     * Get all the specification table data of the product.
     */
    public function spec_data()
    {
        return $this->hasMany(SpecData::class);
    }

    /**
     * Get all the accessories of the product.
     */
    public function accessories()
    {
        return $this->belongsToMany(Product::class, 'accessories', 'product_id', 'accessory_id');
    }

    /**
     * Get all the category that owned product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all the unit that owned product.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    /**
     * Get the variation that owned product.
     */
    public function variation()
    {
        return $this->hasOne(Variation::class);
    }

    /**
     * Get all the brand that owned product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all the spec that owned product.
     */
    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }

    public static function related_products (Product $product)
    {
        return Static::select('id', 'category_id', 'name', 'photo')
            ->with('variation:id,product_id,price,unit,offer,offer_deadline')
            ->where('category_id', $product->category_id)->take(4)->get();
    }
    

    /****************************************
     **              Methods
     ***************************************/

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
