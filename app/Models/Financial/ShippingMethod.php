<?php

namespace App\Models\Financial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class ShippingMethod extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, Translatable;
    use CreateTimeline, HasTenant, CreatorRelationship;
    use SearchableTrait;
    
    /****************************************
     **             Attributes
     ***************************************/
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name',
        // 'description',
        'logo',
        'cost',
        'minimum',
        'is_active'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'description'
    ];
    
    /**
     * Searchable rules.
     * 
     * Columns and their priority in search results.
     * Columns with higher values are more important.
     * Columns with equal values have equal importance.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'shipping_method_translations.name' => 10,
            'cost' => 8,
            'minimum' => 8,
            'shipping_method_translations.description' => 5,
        ],
        'joins' => [
            'shipping_method_translations' => ['shipping_methods.id','shipping_method_translations.shipping_method_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'name',
        'description',
        'logo',
        'cost',
        'minimum',
        'is_active'
    ];
    

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo'      => 'array',
        'is_active' => 'boolean',
    ];



    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get all the orders of the shipping method
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
