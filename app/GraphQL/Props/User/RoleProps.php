<?php

namespace App\GraphQL\Props\User;

use App\Role;
use App\Http\Resources\User\Role as RoleResource;
use App\ModelFilters\User\RoleFilter;
use App\Http\Requests\User\v1\RoleRequest;
use App\Http\Resources\User\RoleCollection;

trait RoleProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'role';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Role::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'permissions:id'
    ];

    protected $more_relations = [
        'permissions'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = RoleResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = RoleCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = RoleFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = RoleRequest::class;
}