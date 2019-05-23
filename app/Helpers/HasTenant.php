<?php

namespace App\Helpers;

use App\Scopes\TenantScope;
use App\Models\Hostname;
use App\User;

trait HasTenant
{
    public static function getTenantId()
    {
        return cache()->rememberForever(request()->getHost(), function () {
            return Hostname::whereDomain( request()->getHost() )->first()->tenant_id ?? false;
        });
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TenantScope);

        static::creating(function($model) {
            if ( env('APPLY_TENANT_FILTERS') ) {
                if ( !$id = static::getTenantId() ) abort(404);
    
                $model->tenant_id = $id;
            }

            if ( self::$create_uuid ?? false )
                $model->id = substr(md5( time() . rand() ), 0, 12);

                
            if ( self::$has_user ?? true )
            {
                if ( app()->runningInConsole() )
                    $model->user_id = User::first()->id;
                
                else 
                    $model->user_id = auth()->user()->id ?? null;
            }

            $model->jalali_created_at = jdate();
        });
    }
}