<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group\Category;
use App\Models\Product\Product;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Unit extends Model implements AuditableContract
{
    use SoftDeletes, Auditable ,Filterable, Translatable;
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
            'unit_translations.title' => 10,
            'unit_translations.description' => 5,
        ],
        'joins' => [
            'unit_translations' => ['units.id','unit_translations.unit_id'],
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
     * Get all the products of the unit.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
