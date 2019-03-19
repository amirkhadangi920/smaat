<?php

namespace App\Models\Discount;

use Illuminate\Database\Eloquent\Model;
use App\Models\Financial\Order;
use Cviebrock\EloquentSluggable\Sluggable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Group\Category;
use EloquentFilter\Filterable;

class Discount extends Model implements AuditableContract 
{
    use Sluggable, Auditable, Filterable;
    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'logo',
        'type',
        'status',
        'start_at',
        'expired_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logo'              => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'start_at',
        'expired_at'
    ];
    
    /****************************************
     **             Relations
     ***************************************/
    
    /**
    * Get all of the discount's user.
    */
    public function user ()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * get the all discount items that owned the discount
     */
    public function items()
    {
        return $this->hasMany(DiscountItem::class);
    }

    /**
     * get the all Order that owned the discount
     */
    public function orders ()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all the categories that owned the category & adverb
     */
    public function categories ()
    {
        return $this->belongsToMany(Category::class);
    }

    /****************************************
     **              Methods
     ***************************************/

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
