<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Unit;
use App\Http\Resources\Feature\Unit as UnitResource;
use App\ModelFilters\Feature\UnitFilter;
use App\Http\Requests\v1\Feature\UnitRequest;
use App\Http\Resources\Feature\UnitCollection;

class UnitController extends FeatureBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'unit';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Unit::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = UnitResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = UnitCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = UnitFilter::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new unit in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(UnitRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $unit in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        return $this->updateWithRequest($request, $unit);
    }
}
