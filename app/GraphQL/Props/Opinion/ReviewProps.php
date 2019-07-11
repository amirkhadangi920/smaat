<?php

namespace App\GraphQL\Props\Opinion;

use App\Models\Opinion\Review;
use App\Http\Resources\Opinion\Review as ReviewResource;
use App\ModelFilters\Opinion\ReviewFilter;
use App\Http\Requests\v1\Opinion\ReviewRequest;
use App\Http\Resources\Opinion\ReviewCollection;

trait ReviewProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'review';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Review::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ReviewResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = ReviewCollection::class;


    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ReviewFilter::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = ReviewRequest::class;
}