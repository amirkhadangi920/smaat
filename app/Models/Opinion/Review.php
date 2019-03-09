<?php

namespace App\Models\Opinion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Product;

class Review extends Model implements AuditableContract
{
    use SoftDeletes, Auditable;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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