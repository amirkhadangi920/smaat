<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Variation;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountItem extends Model implements AuditableContract 
{
    use Auditable, SoftDeletes;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variation_id',
        'offer',
        'quantity',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'offer',
        'quantity',
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
     * get the all discount that owned discount item
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * get the all variation that owned discount item
     */
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
