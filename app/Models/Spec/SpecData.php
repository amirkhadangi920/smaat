<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Product;
use Dimsav\Translatable\Translatable;

class SpecData extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Translatable;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spec_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'spec_row_id',
    ];
    
    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'data',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'data'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the spec row that relate spec data
     */
    public function specRow ()
    {
        return $this->belongsTo(SpecRow::class, 'spec_row_id');
    }
    
    /**
     * Get the spec row that relate spec data
     */
    public function values()
    {
        return $this->belongsToMany(SpecDefault::class, 'spec_data_values');
    }

    /**
     * Get the product that owned spec dara
     */
    public function product ()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
