<?php

namespace App\Models\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Variation;
use App\Models\Group\Category;

class Warranty extends Model implements AuditableContract
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
        'title',
        'description',
        'expire'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /****************************************
     **         Scopes & Mutators
     ***************************************/
    
    /**
     * Name Mutators
     *
     * @return String final_total
     */
    public function getNameAttribute()
    {
        return $this->title.' '.$this->expire;
    }


    /****************************************
     **             Relations
     ***************************************/
    
    /**
     * get the all variation that owned the warranty
     *
     * @return Warranty Model
     */
    public function variations ()
    {
        return $this->hasMany(Variation::class);
    }

    /**
     * get the all variation that owned the warranty
     *
     * @return Warranty Model
     */
    public function category ()
    {
        return $this->belogsTo(Category::class);
    }
}
