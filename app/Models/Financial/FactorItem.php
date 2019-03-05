<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Variation;
use App\Models\Financial\Factor;

class FactorItem extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

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
        'count',
        'price',
        'offer'
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
    public function variation ()
    {
        return $this->belongsTo(Variation::class);
    }

    /**
     * Get all the items of the product
     */
    public function order ()
    {
        return $this->belongsTo(Factor::class);
    }

    /**
     * Get all the items of the user
     */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }
}
