<?php

namespace App\Helpers;

trait JalaliCreatedAt
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->jalali_created_at = jdate();
        });
    }
}