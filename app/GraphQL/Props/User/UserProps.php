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
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'roles:id,name,display_name',
    ];

    protected $more_relations = [
        'permissions'
    ];

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
}