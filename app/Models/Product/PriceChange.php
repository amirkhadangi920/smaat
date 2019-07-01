<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class PriceChange extends Model
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
        'old_price'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'changed_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the variation that this price change
     * is for that
     *
     * @return Variatino Model
     */
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
