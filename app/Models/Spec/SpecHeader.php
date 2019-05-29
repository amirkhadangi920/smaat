<?php

namespace App\Models\Spec;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\CreatorRelationship;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Dimsav\Translatable\Translatable;
use Nicolaslopezj\Searchable\SearchableTrait;

class SpecHeader extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, CreatorRelationship;
    use SoftCascadeTrait, Translatable, SearchableTrait;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->user_id = auth()->user()->id ?? null;
        });
    }

    /****************************************
     **             Attributes
     ***************************************/
    
    /**
     * The relations that must have soft deleted with with model.
     *
     * @var array
     */
    protected $softCascade = [
        'rows',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'spec_id',
        // 'title',
        // 'description',
        'is_active'
    ];
    
    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'description',
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
            'spec_header_translations.title' => 10,
            'spec_header_translations.description' => 5,
        ],
        'joins' => [
            'spec_header_translations' => ['spec_headers.id','spec_header_translations.spec_header_id'],
        ],
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'title',
        'description',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'spec_id',
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
     * Get the spec that relate spec header
     */
    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }

    /**
     * Get the all spec row that owned spec header
     */
    public function rows()
    {
        return $this->hasMany(SpecRow::class);
    }
}
