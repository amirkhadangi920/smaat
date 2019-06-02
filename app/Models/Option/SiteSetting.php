<?php

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Helpers\HasTenant;
use Dimsav\Translatable\Translatable;
use App\Models\Tenant;

class SiteSetting extends Model implements AuditableContract
{
    use Auditable, HasTenant, Translatable;

    /****************************************
     **             Attributes
     ***************************************/

    protected static $has_user = false;

    protected static $jalali_time = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type'
    ];

    /**
     * The attributes that are store in the transltion model.
     *
     * @var array
     */
    public $translatedAttributes = [
        'value'
    ];


    /****************************************
     **             Relations
     ***************************************/

    /**
     * Get the site tenant of the option
     *
     * @return void
     */
    public function site()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
