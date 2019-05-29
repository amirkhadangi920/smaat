<?php

namespace App\Models\Opinion;

use Cog\Likeable\Contracts\Likeable as LikeableContract;
use Cog\Likeable\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Article;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class Comment extends Model implements AuditableContract , LikeableContract
{
    use SoftDeletes, Auditable, Likeable, SearchableTrait;
    use Filterable, CreateTimeline, HasTenant, SoftCascadeTrait;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'answers'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'parent_id',
        'message',
        'is_accept'
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
            'message' => 10,
            'article_translations.title' => 6,
            'users.first_name' => 8,
            'users.last_name' => 8,
        ],
        'joins' => [
            'article_translations' => ['comments.article_id','article_translations.article_id'],
            'users' => ['comments.user_id','users.id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'message',
        'is_accept'
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
    protected $dates = [ 'deleted_at' ];
    

    /****************************************
     **             Relations
     ***************************************/
    
    /**
     * Get the article that the comment has belongs to that
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * relation to user model
     *
     * @return User Model
     */
    public function writer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * This function for answer's comments
     */
    public function answers() {
  
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * This function for answer's comments
     */
    public function question() {
  
        return $this->belongsTo(self::class, 'parent_id');
    }
}