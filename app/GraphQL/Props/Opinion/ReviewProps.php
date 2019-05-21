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
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'product:id,name,photos,label',
        'user:id,first_name,last_name,avatar',
    ];

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'reviews';

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
}