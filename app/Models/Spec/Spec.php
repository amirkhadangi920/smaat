<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\Product\Product;
use EloquentFilter\Filterable;
use App\Helpers\CreateTimeline;
use App\Helpers\HasTenant;

class Spec extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Filterable, CreateTimeline, HasTenant;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'description'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /****************************************
     **             Relations
     ****************************************

    /**
     * Get the category that owned spec.
     */
    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all the spec header of the spec.
     */

    public function headers ()
    {
        return $this->hasMany(SpecHeader::class);
    }

    /**
     * Get all the products of the spec.
     */
    public function products ()
    {
        return $this->hasMany(Product::class);
    }

    public static function compare ()
    {
        if ( !session('compare_table') || !session('compare') ) return null;

        return Static::find( session('compare_table') )
            ->load([
                'specHeaders:id,spec_id,title,description',
                'specHeaders.specRows:id,spec_header_id,title,label,values,help,multiple',
                'specHeaders.specRows.specDatas' => function ($query) {
                    $query->whereIn('product_id', session( 'compare' ) );
                }
            ]);
    }
}
