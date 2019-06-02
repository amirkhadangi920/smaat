<?php

namespace App\Models\Promocode;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Financial\Order;
use App\Models\Group\Category;
use App\Models\Product\Variation;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HasTenant;
use App\Helpers\CreateTimeline;
use App\Helpers\CreatorRelationship;
use Nicolaslopezj\Searchable\SearchableTrait;

class Promocode extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, HasTenant;
    use CreateTimeline, CreatorRelationship, SearchableTrait;

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
        'min_total',
        'max',
        'quantity',
        'reward_type',
        'expired_at',
        'is_active'
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
            'code' => 10,
            'value' => 7,
            'expired_at' => 5,
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'code',
        'value',
        'min_total',
        'max',
        'quantity',
        'reward_type',
        'expired_at',
        'is_active'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'expired_at'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the all orders that owned promocode.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the categories that owned the promocode & adverb
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get all the users that owned the promocode & adverb
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class)->withPivot('used_at');
    }

    /**
     * Get all the variations that owned the promocode & adverb
     */
    public function variations ()
    {
        return $this->belongsToMany(Variation::class);
    }
}