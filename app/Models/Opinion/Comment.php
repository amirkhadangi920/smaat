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

class Comment extends Model implements AuditableContract , LikeableContract
{
    use SoftDeletes, Auditable, Likeable, Filterable, CreateTimeline;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'parent_id',
        'message'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is-accept'      => 'boolean',
    ];
    /**
     * Get the article that the comment has belongs to that
     */
    public function article ()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * relation to user model
     *
     * @return User Model
     */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * This function for answer's comments
     */
    public function answers() {
  
        return $this->hasMany(self::class, 'parent_id');
    }
}