<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GenerateRandomID;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Variation extends Model implements AuditableContract
{
    use SoftDeletes, GenerateRandomID, Auditable;

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
        'color_id', 
        'warranty_id',
        'size_id',
        'price',
        'unit',
        'offer',
        'offer_deadline',
        'inventory',
        'sending_time',
        'status',
        'old_prices',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'old_prices'    => 'array',
        'status'        => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'offer_deadline'
    ];

    /**
     * Relation to Product model
     *
     * @return Product Model
     */
    public function product ()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relation to Color model
     *
     * @return Color Model
     */
    public function color ()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Relation to Warranty model
     *
     * @return Warranty Model
     */
    public function warranty ()
    {
        return $this->belongsTo(Warranty::class);
    }

    /**
     * Relation to orderItem model
     * 
     * @return OrderItem Model
     */
    
    public function order_item ()
    {
        return $this->hasMany(OrderItem::class, 'variation_id');
    }

    /**
     * return tops product varations
     *
     * @return Collection
     */
    public static function getTops ($limit = 5, $more = false)
    {
        $relations = [ 'product:id,name', 'color:id,name,value' ];
        $feilds = ['id', 'product_id', 'color_id'];
        
        if ($more) {
            $relations[0] = 'product:id,name,photo,category_id,label';
            $relations[] = 'product.category:id,title';
            array_push($feilds, 'price', 'offer', 'offer_deadline', 'stock_inventory');
        }

        $result = static::select($feilds)
            ->with($relations)
            ->withCount('order_item')
            ->orderBy('order_item_count', 'desc')
            ->limit($limit)->get();

        return $result;
    }

    public static function productOffers ($order)
    {
        $result = static::where('offer_deadline', '>', now())->with([
            'product:id,name,photo,category_id,label',
            'product.category:id,title'
        ]);
        switch ( $order )
        {
            case 'the_most':        $result->orderBy(DB::raw('price - offer'), 'desc'); break;
            case 'mostـurgent':     $result->orderBy('offer_deadline', 'asc'); break;
        }
        return $result->take(6)->get();
    }

    public function getDeadlineAttribute( $data )
    {
        return Carbon::parse( $this->offer_deadline );
    }
}
