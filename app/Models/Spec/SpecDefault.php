<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreatorRelationship;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class SpecDefault extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, CreatorRelationship;
    use Translatable, SearchableTrait;

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spec_row_id' 
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'value',
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
            'spec_default_translations.value' => 10,
        ],
        'joins' => [
            'spec_default_translations' => ['spec_defaults.id','spec_default_translations.spec_default_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'value'
    ];

    /****************************************
     **             Relations
     ***************************************/

    /**
     * If i want to give one spec data i use it.
     *
     */
    public function row()
    {
        return $this->belongsTo(SpecRow::class);
    }
}
