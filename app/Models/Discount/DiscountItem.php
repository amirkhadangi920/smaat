<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Variation;

class DiscountItem extends Model
{
    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'offer',
        'quantity',
        'sold_count'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo'              => 'array'
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
    public function discount ()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * get the all variation that owned discount item
     */
    public function variation ()
    {
        return $this->belongsTo(Variation::class);
    }
}
