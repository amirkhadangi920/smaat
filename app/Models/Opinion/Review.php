<?php

namespace App\Models\Opinion;

use Cog\Likeable\Contracts\Likeable as LikeableContract;
use Cog\Likeable\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Product;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;
use Nicolaslopezj\Searchable\SearchableTrait;

class Review extends Model implements AuditableContract, LikeableContract
{
    use SoftDeletes, Auditable, Likeable, Filterable;
    use CreateTimeline, HasTenant, SearchableTrait;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'ranks',
        'advantages',
        'disadvantages',
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
            'advantages' => 5,
            'disadvantages' => 5,
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
        'ranks',
        'advantages',
        'disadvantages',
        'message',
        'is_accept'
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ranks'             => 'array',
        'advantages'        => 'array',
        'disadvantages'     => 'array',
        'is_accept'         => 'boolean',
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
     * Get the product that this review belongs to that
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

}