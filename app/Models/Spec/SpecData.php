<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SpecData extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

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
        'data'
    ];

    public function specRow ()
    {
        return $this->belongsTo(SpecRow::class, 'spec_row_id');
    }
}
