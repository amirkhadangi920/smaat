<?php

namespace App\Models;

use Cog\Likeable\Contracts\Likeable as LikeableContract;
use Cog\Likeable\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Traits\GenerateRandomID;
use App\Models\Opinion\Comment;
use Spatie\Tags\HasTags;
use App\Models\Group\Subject;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HasTenantWthRandomID;
use App\Helpers\CreatorRelationship;

class Article extends Model implements AuditableContract , LikeableContract
{
    use Auditable, SoftDeletes, HasTags, Likeable, Filterable;
    use CreateTimeline, HasTenantWthRandomID, CreatorRelationship;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes specifies that table has char type id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'reading_time',
        'image',
        'is_active'
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'title',
        'description',
        'body',
        'reading_time',
        'image',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'tenant_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'jalali_created_at',
        'deleted_at'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
    * Get all of the article's user.
    */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    
    /**
     * Get all of the article's comments.
     */
    public function comments ()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * Get all the subjects that owned article & adverb
     */
    public function subjects ()
    {
        return $this->belongsToMany(Subject::class);
    }
}
