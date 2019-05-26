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

class QuestionAndAnswer extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable;
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
        'message',
        'is_accept'
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