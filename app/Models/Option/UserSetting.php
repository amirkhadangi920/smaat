<?php

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Dimsav\Translatable\Translatable;
use App\User;

class UserSetting extends Model implements AuditableContract
{
    use Auditable, Translatable;
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->id ?? false);
        });

        static::creating(function($model) {
            if ( app()->runningInConsole() )
                $model->user_id = User::first()->id;
                
            else 
                $model->user_id = auth()->user()->id ?? false;
        });
    }

    /****************************************
     **             Attributes
     ***************************************/

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
