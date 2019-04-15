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

class Review extends Model implements AuditableContract, LikeableContract
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
        'product_id',
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
        'ranks'         => 'array',
        'advantages'    => 'array',
        'disadvantages' => 'array',
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
     * Get the product that this review belongs to that
     */
    public function product ()
    {
        return $this->belongsTo(Product::class);
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

}