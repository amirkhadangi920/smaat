<?php

namespace App\GraphQL\Props\User;

use App\UserAddress;
use App\Http\Requests\User\v1\UserAddressRequest;

trait UserAddressProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'user_address';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = UserAddress::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = UserAddressRequest::class;
}