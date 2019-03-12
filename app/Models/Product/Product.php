<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\GenerateRandomID;
use App\Models\Spec\{ SpecData, Spec };
use App\Models\Group\Category;
use App\Models\Opinion\{ Review, QuestionAndAnswer };
use Spatie\Tags\HasTags;
use App\Models\Feature\Brand;
use App\Models\Feature\Unit;
use EloquentFilter\Filterable;

class Product extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Sluggable, GenerateRandomID, HasTags, Filterable;

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

    public static function productCard ($query = null, $options = [])
    {
        $feilds = ['id', 'name', 'photo', 'label', 'category_id', 'brand_id'];
        if ( auth()->check() )
            $feilds = array_merge( $feilds, [ 'code', 'status' ]);

        if ( isset($options['more']) )
            $feilds = array_merge( $feilds, [ 'advantages', 'disadvantages', 'code' ]);
        
        $relations = [
            'variation:id,product_id,color_id,warranty_id,price,unit,offer,offer_deadline,stock_inventory',
            'variation.color:id,name,value',
            'variation.warranty:id,title,expire',
            'category:id,title',
            'brand:id,title',
        ];
        if ( isset($options['orderby']) )
        {
            if ( $options['orderby'] == 'most_expensive' )
            {
                $relations['variation'] = function ($query) {
                    $query->orderBy('price', 'asc');
                };
            }
            elseif ($options['orderby'] == 'cheapest')
            {
                $relations['variation'] = function ($query) {
                    $query->orderBy('price', 'desc');
                };
            }
        }
        $result = Static::select($feilds)->with( $relations );
        
        if ( !auth()->check() )
        {
            $result->where('status', 1);
        }

        if ( isset($options['products']) )
        {
            $result->whereIn('id', $options['products']);
        }

        if ( isset($options['category']) )
        {
            $result->where('category_id', $options['category']);
        }

        if ($query)
            $result->where('name', 'like', '%'.$query.'%');

        if ( isset($options['color']) )
        {
            $result->whereHas('variations', function ($query) use ($options) {
                $query->whereIn('color_id', $options['color']);
            });
        }

        if ( isset($options['price_from']) )
        {
            $result->whereHas('variations', function ($query) use ($options) {
                $query->where('price', '>', $options['price_from'] * 1000);
            });
        }

        if ( isset($options['price_to']) )
        {
            $result->whereHas('variations', function ($query) use ($options) {
                $query->where('price', '<', $options['price_to'] * 1000);
            });
        }
         
        if ( isset($options['brand']) )
            $result->whereIn('brand_id', $options['brand']);
        
        if ( isset($options['orderby']) && $options['orderby'] == 'oldest' )
        {
            return $result->orderBy('created_at', 'desc')->paginate(20);
        }
        if ( !isset($options['orderby']) || isset($options['orderby']) && $options['orderby'] == 'newest' )
        {
            $result->latest();
        } 
        return $result->paginate(20);
    }

    public static function productInfo ($product, $options = [])
    {
        $relations = [
            // Specification table full relations
            'spec:id',
            'spec.specHeaders:id,spec_id,title,description',
            'spec.specHeaders.specRows:id,spec_header_id,title,label,values,help,multiple',
            'spec.specHeaders.specRows.specData' => function ($query) use ($product) {
                $query->where('product_id', $product->id);
            },
            // Product variations full relations
            'variations',
            'variations.color:id,name,value',
            'variations.warranty:id,title,expire',
            'category:id,title',
            'brand:id,title',
        ];
        if ( isset($options['reviews']) )
        {
            $relations[] = 'reviews';
            $relations[] = 'reviews.user:id,first_name,last_name,avatar';
            $relations['reviews'] = function ( $query ) {
                $query->orderBy('created_at', 'desc');
            };
        }
        return $product->load($relations);
    }

    public static function related_products (Product $product)
    {
        return Static::select('id', 'category_id', 'name', 'photo')
            ->with('variation:id,product_id,price,unit,offer,offer_deadline')
            ->where('category_id', $product->category_id)->take(4)->get();
    }

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
