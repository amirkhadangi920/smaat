<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use \Morilog\Jalali\Jalalian;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GenerateRandomID;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Discount\Discount;

class Order extends Model
{
    use SoftDeletes, GenerateRandomID, Auditable;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * Different types of Factor constants
     */
    const SELL = 1;
    const BUY = 2;
    const SELL_BACK = 3;
    const BUY_BACK = 4;

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
        // 'discount_code_id',
        'descriptions',
        'destination',
        'postal_code',
        'offer',
        'total',
        'tax',
        'created_at',
        'auth_code',
        'payment_code',
        // 'payment_jalali',
        'datetimes',
        'shipping_methods',
        'status',
        'paid_at',
        'jalali_paid_at',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'descriptions'  => 'array',
        'shipping'      => 'array',
        'datetimes'     => 'array'
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
    public function user ()
    {
        return $this->belongsTo(\App\User::class, 'buyer');
    }

    /**
     * Get all the items of the product
     */
    public function items ()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discount ()
    {
        return $this->belongsTo(Discount::class);
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
    public static function total ( $period )
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
