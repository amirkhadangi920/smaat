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

class OrderStatus extends Model implements AuditableContract
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
        // 'title',
        // 'description',
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
            'order_status_translations.title' => 10,
            'color' => 6,
            'order_status_translations.description' => 5,
        ],
        'joins' => [
            'order_status_translations' => ['order_statuses.id','order_status_translations.order_status_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'title',
        'description',
        'color',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
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
     * Get all the orders of the order status
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
