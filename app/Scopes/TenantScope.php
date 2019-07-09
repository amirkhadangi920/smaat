<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Hostname;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $tenant_id = cache()->rememberForever(request()->getHost(), function () {
            return Hostname::whereDomain( request()->getHost() )->first()->tenant_id ?? false;
        });

        if ( !$tenant_id && env('APPLY_TENANT_FILTERS', true) ) abort(404);

        if( env('APPLY_TENANT_FILTERS', true) )
            $builder->where( $model->getTable().'.tenant_id', $tenant_id)
                    ->orWhereNull( $model->getTable().'.tenant_id' );
    }
}