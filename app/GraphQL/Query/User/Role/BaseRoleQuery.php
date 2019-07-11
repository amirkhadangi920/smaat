<?php

namespace App\GraphQL\Query\User\Role;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\User\RoleProps;

class BaseRoleQuery extends MainQuery
{
    use RoleProps;

    protected $translatable = true;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-role');
    }
}