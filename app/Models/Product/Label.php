<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreatorRelationship;
use App\Helpers\HasTenant;
use Dimsav\Translatable\Translatable;
use App\Helpers\CreateTimeline;

class Label extends Model implements AuditableContract
{
    use SoftDeletes, HasTenant, Auditable, CreatorRelationship;
    use Translatable, CreateTimeline;

    /****************************************
     **             Attributes
     ***************************************/

    protected static $jalali_time = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color', 
        'is_active'
    ];
    
    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'description',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'color', 
        'is_active'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active'             => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];


    /****************************************
     **             Relations
     ***************************************/

    /**
     * Relation to Product model
     *
     * @return Product Model
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
