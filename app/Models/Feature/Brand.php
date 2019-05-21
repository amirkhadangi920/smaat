<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use EloquentFilter\Filterable;
use App\Models\Group\Category;
use App\Models\Product\Product;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\User;
use App\Helpers\CreatorRelationship;

class Brand extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable;
    use CreateTimeline, HasTenant, CreatorRelationship;

    /****************************************
     **             Attributes
     ***************************************/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo',
        'name',
        'description',
        'is_active'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'logo',
        'name',
        'description',
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
     * Get all the products of the brand.
     */
    public function products ()
    {
        return $this->hasMany(Product::class);
    }


    /****************************************
     **              Methods
     ***************************************/

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return [
            $this->name,
            'roles' => auth()->user()->roles->pluck('name'),
        ];
    }
}
