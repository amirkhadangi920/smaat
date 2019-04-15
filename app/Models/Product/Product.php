<?php

namespace App\Models\Product;

use Cog\Likeable\Contracts\Likeable as LikeableContract;
use Cog\Likeable\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Traits\GenerateRandomID;
use App\Models\Opinion\{ Review, QuestionAndAnswer };
use Spatie\Tags\HasTags;
use App\Models\Spec\{ SpecData, Spec };
use App\Models\Group\Category;
use App\Models\Feature\{ Brand, Unit };
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;

class Product extends Model implements AuditableContract, LikeableContract
{
    use SoftDeletes, Auditable, GenerateRandomID, HasTags, Filterable, Likeable, CreateTimeline;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes specifies that table has char type id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'spec_id',
        'name',
        'second_name',
        'code',
        'description',
        'note',
        'aparat_video',
        'status',
        'review',
        'advantages',
        'disadvantages',
        'label',
        'views_count',
        'photos',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status'    => 'boolean',
        'keywords' => 'array',
        'photos' => 'array',
        'advantages' => 'array',
        'disadvantages' => 'array',
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
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Get all the variations of the product.
     */
    public function variations ()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Get all of the users like some products
     */
    public function favorites ()
    {
        return $this->belongsToMany(\App\User::class, 'favorites');
    }

    /**
     * Get all the reviews of the product.
     */
    public function reviews ()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get all the questionAndAnsers of the product.
     */
    public function questions ()
    {
        return $this->hasMany(QuestionAndAnswer::class)->whereIsNull('question_id');
    }
    
    /**
     * Get all the specification table data of the product.
     */
    public function spec_data ()
    {
        return $this->hasMany(SpecData::class);
    }

    /**
     * Get all the accessories of the product.
     */
    public function accessories()
    {
        return $this->belongsToMany(Product::class, 'accessories', 'accessory_id');
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
    public function variation ()
    {
        return $this->hasOne(Variation::class);
    }

    /**
     * Get all the brand that owned product.
     */
    public function brand ()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all the spec that owned product.
     */
    public function spec ()
    {
        return $this->belongsTo(Spec::class);
    }

    public static function related_products (Product $product)
    {
        return Static::select('id', 'category_id', 'name', 'photo')
            ->with('variation:id,product_id,price,unit,offer,offer_deadline')
            ->where('category_id', $product->category_id)->take(4)->get();
    }
}
