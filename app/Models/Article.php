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

class Article extends Model implements AuditableContract , LikeableContract
{
    use Auditable, GenerateRandomID, HasTags, Likeable, Filterable;

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
        'image'
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
