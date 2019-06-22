<?php

namespace App\Models\Opinion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Product;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Nicolaslopezj\Searchable\SearchableTrait;

class QuestionAndAnswer extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, SearchableTrait;
    use CreateTimeline, HasTenant, SoftCascadeTrait;

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
        'product_id',
        'question_id',
        'title',
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
            'product_translations.name' => 6,
            'product_translations.second_name' => 6,
            'users.first_name' => 8,
            'users.last_name' => 8,
        ],
        'joins' => [
            'product_translations' => ['comments.product_id','product_translations.product_id'],
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
        'is_accept'      => 'boolean',
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
     * Get the product that this question or answers
     * record for that
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
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
     * Get all the asnwers of the question
     */
    public function answers()
    {
        return $this->hasMany(QuestionAndAnswer::class, 'question_id');
    }

    /**
     * Get the question of the answer
     */
    public function question()
    {
        return $this->belongsTo(QuestionAndAnswer::class);
    }
}