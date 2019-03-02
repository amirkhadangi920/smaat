<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Coupen extends Model implements AuditableContract
{
    use Auditable;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'value',
        'using_time'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'using_time'
    ];

    /**
     * Get the user that using this discount code
     */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }
}
