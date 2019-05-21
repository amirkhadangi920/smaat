<?php

namespace App\GraphQL\Props\Spec;

use App\Models\Spec\Spec;
use App\Http\Resources\Spec\Spec as SpecResource;
use App\ModelFilters\Spec\SpecFilter;
use App\Http\Requests\v1\Spec\SpecificationRequest;
use App\Http\Resources\Spec\SpecCollection;

trait SpecProps
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
        'category:id,title'
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

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = SpecCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = SpecFilter::class;
}