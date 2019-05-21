<?php

namespace App\GraphQL\Query\User\User;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\User\UserProps;

class BaseUserQuery extends MainQuery
{
    use UserProps;

    protected $incrementing = false;

    protected $acceptable = false;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-user');
    }
}