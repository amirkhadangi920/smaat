<?php

namespace App\GraphQL\Query\User\Role;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class RolesQuery extends BaseRoleQuery
{
    use AllQuery;
    
    public function type()
    {
        return Type::listOf( \GraphQL::type( $this->type ) );
    }

    public function getPortionOfData($data, $args)
    {
        return $data->get();
    }
}