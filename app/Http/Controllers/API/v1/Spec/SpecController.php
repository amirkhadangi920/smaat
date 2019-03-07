<?php

namespace App\Http\Controllers\API\v1\Spec;

use App\Models\Spec\Spec;
use App\Http\Resources\Spec\Spec as SpecResource;
use App\Http\Controllers\API\v1\MainController;

class SpecController extends MainController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'specification';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Spec::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'category:id,slug,title'
    ];

    protected $more_relations = [
        'headers:id,spec_id,title,description',
        'headers.rows:id,spec_header_id,title,description,label,values,help,multiple,required'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecResource::class;
}