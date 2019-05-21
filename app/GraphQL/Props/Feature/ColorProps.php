<?php

namespace App\GraphQL\Props\Feature;

use App\Models\Feature\Color;
use App\Http\Resources\Feature\Color as ColorResource;
use App\ModelFilters\Feature\ColorFilter;
use App\Http\Requests\v1\Feature\ColorRequest;
use App\Http\Resources\Feature\ColorCollection;

trait ColorProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'color';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Color::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ColorResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = ColorCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ColorFilter::class;
}