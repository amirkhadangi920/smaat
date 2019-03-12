<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Size;
use App\Http\Resources\Feature\Size as SizeResource;
use App\ModelFilters\Feature\SizeFilter;
use App\Http\Requests\v1\Feature\SizeRequest;

class SizeController extends FeatureBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'size';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Size::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SizeResource::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = SizeFilter::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new size in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(SizeRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $size in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(SizeRequest $request, Size $size)
    {
        return $this->updateWithRequest($request, $size);
    }
}
