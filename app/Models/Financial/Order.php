<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use \Morilog\Jalali\Jalalian;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Discount\Discount;
use App\Models\Promocode\Promocode;
use App\Models\Places\City;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Order extends Model implements AuditableContract
{
    use SoftDeletes, HasTenant, Auditable;
    use Filterable, CreateTimeline, SoftCascadeTrait;

    /****************************************
     **             Attributes
     ***************************************/
        
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'items'
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
        'shipping_method_id',
        'order_status_id',
        'city_id',
        'descriptions',
        'destination',
        'phone_number',
        'postal_code',
        'offer',
        'total',
        'tax',
        'shipping_cost',
        'docs',
        // 'payment_jalali',
        'datetimes',
        'paid_at',
        'jalali_paid_at',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'shipping_method_id',
        'order_status_id',
        'city_id',
        'destination',
        'phone_number',
        'postal_code',
        'offer',
        'total',
        'shipping_cost',
        'paid_at',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'descriptions'  => 'array',
        'shipping'      => 'array',
        'datetimes'     => 'array',
        'docs'          => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'paid_at',
        'jalali_paid_at'
    ];


    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the user that create or buy the order
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Get all the items of the product
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the discount that owned the order
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * Get the order status that owned the order
     */
    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Get the promocode that owned the order
     */
    public function promocode()
    {
        return $this->belongsTo(Promocode::class);
    }
    
    /**
     * Get the shipping method that owned the order
     */
    public function shipping_method()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    /**
     * Get the city that owned the order
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }


    /****************************************
     **               Methods
     ***************************************/

    public function total()
    {
        return $this->total = $this->items->sum(function ($item) {
            return $item->price * $item->count;
        });
    }

    public function calculateTotal()
    {
        return ( $this->total + $this->shipping_cost ) - $this->offer;
    }

    public function promocodeHasExpired()
    {
        if ( $this->promocode->expired_at->lt(now()) )
            $this->promocode = null;

        return $this;
    }

    public function promocodeCheckMinimum()
    {
        if ( $this->total() <= $this->promocode->min_total )
            $this->promocode = null;

        return $this;
    }

    public function promocodeCheckQuantity()
    {
        if ( !is_null( $this->promocode->quantity ) && $this->promocode->quantity < 1 )
            $this->promocode = null;

        return $this;
    }

    public function promocodeCheckValidUsers()
    {
        $users = $this->promocode->users;

        if ( $users->isNotEmpty() && $users->whereIn('id', auth()->user()->id )->count() !== 1 )
            $this->promocode = null;

        return $this;
    }

    public function promocodeCheckBeforeUsed()
    {
        $orders = auth()->user()->orders()->where('order_status_id', '!=', 1);
            
        if ( $orders->where('promocode_id', $this->promocode_id)->get()->count() !== 0 )
            $this->promocode = null;

        return $this;
    }

    public function canUsePromocode()
    {
        if ( $this->promocode )
        {
            $this->promocodeHasExpired()
                 ->promocodeCheckMinimum()
                 ->promocodeCheckQuantity()
                 ->promocodeCheckBeforeUsed();
        }
        
        return $this;
    }

    public function promocodeGetValidVariations()
    {
        $variations = $this->promocode->variations;

        if ( $variations->isNotEmpty() )
            return $variations = $variations->whereIn('id', $this->items->pluck('variation.id') );

        return collect();
    }

    public function promocodeGetValidCategories()
    {
        $categories = $this->promocode->categories;

        if ( $categories->isNotEmpty() )
        {
            $categories = $categories->whereIn( 'id',
                $this->items->pluck('variation.product.category.id')
            )->pluck('id');

            return $this->items->whereIn('variation.product.category.id', $categories)->pluck('variation');
        }

        return collect();
    }

    public function promocodeGetValidVariationsOffer($variations)
    {
        $cart_items = $this->items->keyBy('variation.id');

        $order_total = $variations->sum(function ($item) use($cart_items) {
            
            return $item->final_price * $cart_items[ $item->id ]->count;
        });

        $offer = (integer) ( ( $order_total * $this->promocode->value ) / 100 );
        
        if ( $this->promocode->max && $this->promocode->max < $offer )
            $offer = $this->promocode->max;

        return $offer;
    }

    public function calculatePromocodeOffer()
    {
        if ( !$this->promocode ) return $this;
        
        $variations = $this->promocodeGetValidVariations()->merge(
            $this->promocodeGetValidCategories()
        );

        $this->offer = $this->promocodeGetValidVariationsOffer( $variations );
    
        return $this;
    }

    public function usePromocode()
    {
        if ( !$this->promocode || !$this->promocode->quantity ) return $this;

        

        $this->promocode->decrement('quantity');

        dd( $this->promocode );

        return $this;
    }

    public function calculateShippingCost()
    {
        if ( !$this->shipping_method ) return $this;
        
        $this->shipping_cost = $this->shipping_method->cost;

        return $this;
    }

    /**
     * return list of orders
     *
     * @return Collection
     */
    public static function list ()
    {
        return Static::select('id', 'buyer', 'status', 'created_at', 'payment', 'total', 'offer', 'shipping_cost')
            ->with('user:id,first_name,last_name,email')->latest()->paginate(20);
    }
    
    /**
     * return total of orders price according to period of time
     *
     * @param String $period
     * @return Collection
     */
    public static function get_total ( $period )
    {
        /**
         * Highlighting type of requested period
         * @param String $period
         */
        switch ( $period )
        {
            case 'daily':   $period = 'day';   $before = '1 month'; break;
            case 'weekly':  $period = 'week';  $before = '3 month'; break;
            case 'monthly': $period = 'month'; $before = '1 year';  break;
            case 'yearly':  $period = 'year';  $before = '10 year'; break;
        }

        return Static::select([
            DB::raw("$period(payment_jalali) as 'period'"),
            DB::raw("SUM(total - offer) 'sum'")
        ])
        ->groupBy('period')
        ->where( 'payment_jalali', '>', Jalalian::forge("now - $before") )
        ->whereNotNull('payment_jalali')->get();
    }

    /**
     * return total of income
     *
     * @return Integer
     */
    public static function total_income ()
    {
        return static::select([ DB::raw("SUM(total - offer) AS 'sum'") ])
            ->whereNotNull('payment_jalali')->get()[0]->sum;
    }

    /**
     * return compare the count of orders from prevoius month
     *
     * @return Int
     */
    public static function compare ()
    {
        $month = Jalalian::forge("now")->getMonth();
        $result = Static::select([
                DB::raw("MONTH(payment_jalali) as 'period'"),
                DB::raw("COUNT(id) 'count'")
            ])
            ->groupBy('period')
            ->whereIn( DB::raw("MONTH(payment_jalali)"), [$month, $month - 1])
            ->where( 'payment_jalali', '>', Jalalian::forge("now - 2 month") )
            ->whereNotNull('payment_jalali')->get();

        return ($result == []) 
            ? round( ( $result[1]->count - $result[0]->count ) * 100 / $result[1]->count )
            : 0; 
    }

    /**
     * return full informatino of specific orders
     *
     * @return Object
     */
    public static function full_info ($order)
    {
        $order->user = $order->user()->get()[0];
        $order->items = $order->items()->with([
            'variation',
            'variation.warranty:id,title,expire',
            'variation.color:id,name,value',
            'variation.product:id,name,code,photo'
        ])->get();

        return $order;
    }

    /**
     * Fianl_Total Mutators
     *
     * @return String final_total
     */
    public function getFinalTotalAttribute()
    {
        return ( $this->shipping_cost + $this->total ) - $this->offer;
    }

    /**
     * Full_name Mutators
     *
     * @return String
     */
    public function getFullNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}
