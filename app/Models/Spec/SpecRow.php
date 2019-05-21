<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreatorRelationship;

class SpecRow extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, CreatorRelationship;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spec_header_id',
        'title',
        'description',
        'label',
        'values',
        'help',
        'multiple',
        'required',
        'is_active'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'title',
        'description',
        'label',
        'values',
        'help',
        'multiple',
        'required',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'values'    => 'array',
        'multiple'  => 'boolean',
        'required'  => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'spec_header_id',
    ];

    /****************************************
     **             Relations
     ***************************************/

     /**
     * Get the all of the spec row that owned spec header 
     *
     */
    public function header ()
    {
        return $this->belongsTo(SpecHeader::class, 'spec_header_id');
    }

    /**
     * If i want to give one spec data i use it.
     *
     */
    public function data ()
    {
        return $this->hasOne(SpecData::class, 'spec_row_id');
    }

    /**
     * Get the all of the spec data that owned spec row 
     *
     */
    public function datas ()
    {
        return $this->hasMany(SpecData::class, 'spec_row_id');
    }
}
