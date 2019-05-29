<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Group\Category;
use App\Models\Product\Variation;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Size extends Model implements AuditableContract
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
        // 'name' , 
        // 'description',
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
            'size_translations.name' => 10,
            'size_translations.description' => 5,
        ],
        'joins' => [
            'size_translations' => ['sizes.id','size_translations.size_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'name' , 
        'description',
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
     * Get all of the tags for the post.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'featureable');
    }

    /**
     * Relation to variation model
     * 
     * @return OrderItem Model
     */
    
    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
