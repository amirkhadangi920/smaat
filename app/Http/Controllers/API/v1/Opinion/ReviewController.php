<?php

namespace App\Http\Controllers\API\v1\Opinion;

use App\Models\Opinion\Review;
use App\Http\Resources\Opinion\Review as ReviewResource;
use App\ModelFilters\Opinion\ReviewFilter;
use App\Http\Requests\v1\Opinion\ReviewRequest;
use App\Helpers\LikeableController;
use App\Http\Resources\Opinion\ReviewCollection;

class ReviewController extends OpinionBaseController
{
    use LikeableController;

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
        'writer:id,first_name,last_name,avatar',
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

    /**
     * Get the request from url and pass it to storeData method
     * to create a new review in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(ReviewRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $review in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(ReviewRequest $request, Review $review)
    {
        return $this->updateWithRequest($request, $review);
    }
}
