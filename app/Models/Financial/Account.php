<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use \Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GenerateRandomID;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Account extends Model
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
        //
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'descriptions'  => 'array',
        // 'shipping'      => 'array',
        // 'datetimes'     => 'array'
        // 'logo'              => 'array'
    ];
   

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'deleted_at' ];


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
}
