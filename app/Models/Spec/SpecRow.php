<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class SpecRow extends Model implements AuditableContract
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
        'title',
        'description',
        'label',
        'values',
        'help',
        'multiple',
        'required',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'values'    => 'array',
        'multiple'  => 'boolean',
        'required'  => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /****************************************
     **             Relations
     ***************************************/

     /**
     * Get the all of the spec row that owned spec header 
     *
     */
    public function specHeader ()
    {
        return $this->belongsTo(SpecHeader::class, 'spec_header_id');
    }

    /**
     * If i want to give one spec data i use it.
     *
     */
    public function specData ()
    {
        return $this->hasOne(SpecData::class, 'spec_row_id');
    }

    /**
     * Get the all of the spec data that owned spec row 
     *
     */
    public function specDatas ()
    {
        return $this->hasMany(SpecData::class, 'spec_row_id');
    }
}
