<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Color;
use App\Http\Resources\Feature\Color as ColorResource;
use App\ModelFilters\Feature\ColorFilter;
use App\Http\Requests\v1\Feature\ColorRequest;
use App\Http\Resources\Feature\ColorCollection;

class ColorController extends FeatureBaseController
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

    /**
     * Get the request from url and pass it to storeData method
     * to create a new color in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(ColorRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $color in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(ColorRequest $request, Color $color)
    {
        return $this->updateWithRequest($request, $color);
    }
}