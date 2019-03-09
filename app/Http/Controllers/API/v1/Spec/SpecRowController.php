<?php

namespace App\Http\Controllers\API\v1\Spec;

use App\Models\Spec\SpecRow;
use App\Http\Resources\Spec\SpecRow as SpecRowResource;
use App\Http\Controllers\API\v1\MainController;

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
}
