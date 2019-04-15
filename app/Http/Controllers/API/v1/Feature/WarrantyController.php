<?php

namespace App\Http\Controllers\API\v1\Feature;

use App\Models\Feature\Warranty;
use App\Http\Resources\Feature\Warranty as WarrantyResource;
use App\ModelFilters\Feature\WarrantyFilter;
use App\Http\Requests\v1\Feature\WarrantyRequest;
use App\Http\Resources\Feature\WarrantyCollection;

class WarrantyController extends FeatureBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'warranty';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Warranty::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = WarrantyResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = WarrantyCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = WarrantyFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';

    /**
     * Get the request from url and pass it to storeData method
     * to create a new warranty in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(WarrantyRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $warranty in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(WarrantyRequest $request, Warranty $warranty)
    {
        return $this->updateWithRequest($request, $warranty);
    }
}
