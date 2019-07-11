<?php

namespace App\GraphQL\Props\User;

use App\ModelFilters\User\UserFilter;
use App\User;
use App\Http\Requests\User\v1\UserRequest;
use App\Http\Resources\User\User as UserResource;
use App\Http\Resources\User\UserCollection;

trait UserProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'user';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = User::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = UserResource::class;
    
    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = UserCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = UserFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'avatar';
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = UserRequest::class;
}