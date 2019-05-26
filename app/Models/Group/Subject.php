<?php

namespace App\Models\Group;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Tags\HasTags;
use App\Models\Article;
use App\Traits\MultiLevel;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use App\Helpers\CreatorRelationship;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Dimsav\Translatable\Translatable;

class Subject extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, HasTags, MultiLevel, Sluggable;
    use CreateTimeline, HasTenant, CreatorRelationship, SoftCascadeTrait;
    use Translatable;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'childs'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        // 'title',
        // 'description',
        'logo',
        'is_active'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'slug',
        'title',
        'description',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'parent_id',
        'title',
        'description',
        'logo',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo'      => 'array',
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
     * Get all the child categories that owned by the category
     */
    public function childs ()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    
    /**
     * return parent category that can have many childs
     */
    public function parent ()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get all the articles that owned the category & adverb
     */
    public function articles ()
    {
        return $this->belongsToMany(Article::class);
    }
    

    /****************************************
     **              Methods
     ***************************************/

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}