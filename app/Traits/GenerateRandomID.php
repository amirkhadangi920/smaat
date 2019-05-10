<?php

namespace App\Traits;

Trait GenerateRandomID
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = substr(md5( time() . rand() ), 0, 12);
        });
    }
}
