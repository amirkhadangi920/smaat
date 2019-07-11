<?php

namespace App\Helpers;

use Spatie\MediaLibrary\Models\Media;

trait MediaConversionsTrait
{
    /**
     * Create conversions for media library
     *
     * @param Media $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this
            ->addMediaConversion('thumb')
            ->keepOriginalImageFormat()
            ->width(100)
            ->height(100)
            ->sharpen(10);

        $this
            ->addMediaConversion('small')
            ->keepOriginalImageFormat()
            ->width(250)
            ->height(250);

        $this
            ->addMediaConversion('medium')
            ->keepOriginalImageFormat()
            ->width(500)
            ->height(500);

        $this
            ->addMediaConversion('large')
            ->keepOriginalImageFormat()
            ->width(1024)
            ->height(800);

        $this
            ->addMediaConversion('wide')
            ->keepOriginalImageFormat()
            ->width(1680)
            ->height(1200);
    }
}