<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Variation;
use App\Models\Financial\Order;
use App\Traits\GenerateRandomID;
use App\Helpers\JalaliCreatedAt;

class OrderItem extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, GenerateRandomID;

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
        'variation_id',
        'count',
        'price',
        'offer',
        'description'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'count',
        'price',
        'offer',
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
     * Relation to ProductVariation Model
     *
     */
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    /**
     * Get all the items of the product
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    /****************************************
     **               Methods
     ***************************************/

    public function priceAndOffer()
    {
        $this->price = $this->variation->sales_price;
            
        if ( $offer = $this->variation->getOffer() )
        {
            if ( $offer = $this->price - $offer > 0) 
                $this->offer = $this->price - $offer;
        }

        return $this;
    }

    public function checkInventory()
    {
        if ( $this->variation->inventory && $this->variation->inventory <= $this->count )
            $this->count = $this->variation->inventory;
        
        return $this;
    }

    public function checkLabel()
    {
        if ( !is_null( $this->variation->product->label ?? null ) )
            $this->delete();
    }

    public function checkQuantity()
    {
        if ( $this->variation->inventory && $this->variation->inventory === 0 )
            $this->delete();
    }
}
