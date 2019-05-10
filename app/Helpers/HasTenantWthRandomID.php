<?php

namespace App\Helpers;

use App\Scopes\TenantScope;
use App\Models\Hostname;

trait HasTenantWthRandomID
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
            if( env('APPLY_TENANT_FILTERS') ) {
                if ( !$id = static::getTenantId() ) abort(404);

                $model->tenant_id = $id;
            }

            $model->id = substr(md5( time() . rand() ), 0, 12);
            $model->jalali_created_at = jdate();
        });
    }
}