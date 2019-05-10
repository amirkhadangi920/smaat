<?php

namespace App\Http\Controllers\API\v1\Spec;

use App\Models\Spec\SpecRow;
use App\Http\Resources\Spec\SpecRow as SpecRowResource;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Requests\v1\Spec\SpecificationRowRequest;

class SpecRowController extends MainController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'specification_row';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SpecRow::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'header:id,title,description'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecRowResource::class;
    
    /**
     * Get the request from url and pass it to storeData method
     * to create a new spec_row in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(SpecificationRowRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $spec_row in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(SpecificationRowRequest $request, SpecRow $spec_row)
    {
        return $this->updateWithRequest($request, $spec_row);
    }
}
