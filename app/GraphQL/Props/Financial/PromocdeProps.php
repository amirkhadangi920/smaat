<?php

namespace App\GraphQL\Props\Financial;

use App\Models\Promocode\Promocode;
use App\Http\Resources\Financial\Promocode as PromocodeResource;
use App\Http\Requests\v1\Order\PromocodeRequest;
use App\ModelFilters\Financial\PromocodeFilter;

trait PromocdeProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'promocode';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Promocode::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = PromocodeResource::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = PromocodeFilter::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = PromocodeRequest::class;
}