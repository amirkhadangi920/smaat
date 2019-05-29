<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Group\Category;
use EloquentFilter\Filterable;
use App\Helpers\HasTenant;
use App\Helpers\CreateTimeline;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\CreatorRelationship;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Discount extends Model implements AuditableContract 
{
    use Auditable, Filterable, HasTenant, Translatable;
    use CreateTimeline, SoftDeletes, CreatorRelationship, SoftCascadeTrait;
    use SearchableTrait;
    
    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'items'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'title',
        // 'description',
        'logo',
        'type',
        'status',
        'started_at',
        'expired_at',
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
            'discount_translations.title' => 10,
            'discount_translations.description' => 5,
        ],
        'joins' => [
            'discount_translations' => ['discounts.id','discount_translations.discount_id'],
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
        'logo',
        'started_at',
        'expired_at',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'started_at',
        'expired_at'
    ];
    
    /****************************************
     **             Relations
     ***************************************/
    
    /**
    * Get all of the discount's user.
    */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * get the all discount items that owned the discount
     */
    public function items()
    {
        return $this->hasMany(DiscountItem::class);
    }

    /**
     * get the all Order that owned the discount
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the categories that owned the category & adverb
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /****************************************
     **              Methods
     ***************************************/
}
