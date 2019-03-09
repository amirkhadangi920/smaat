<?php

namespace App\Models\Opinion;

use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Article;

class Comment extends Model implements AuditableContract , LikeableContract
{
    use SoftDeletes, Auditable, Likeable;

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