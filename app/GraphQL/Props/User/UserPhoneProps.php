<?php

namespace App\GraphQL\Props\User;

use App\UserPhone;
use App\Http\Requests\User\v1\UserPhoneRequest;

trait UserPhoneProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'user_phone';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = UserPhone::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = UserPhoneRequest::class;
}