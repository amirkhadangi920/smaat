<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Variation;
use App\Models\Group\Category;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Warranty extends Model implements AuditableContract
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
        // 'expire',
        'logo',
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
        'expire'
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
            'warranty_translations.title' => 10,
            'warranty_translations.description' => 5,
            'warranty_translations.expire' => 5,
        ],
        'joins' => [
            'warranty_translations' => ['warranties.id','warranty_translations.warranty_id'],
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
        'expire',
        'logo',
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
    protected $dates = ['deleted_at'];


    /****************************************
     **         Scopes & Mutators
     ***************************************/
    
    /**
     * Name Mutators
     *
     * @return String final_total
     */
    public function getNameAttribute()
    {
        return $this->title.' '.$this->expire;
    }


    /****************************************
     **             Relations
     ***************************************/
    
    /**
     * get the all variation that owned the warranty
     *
     * @return Warranty Model
     */
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * Get all of the tags for the post.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'featureable');
    }
}
