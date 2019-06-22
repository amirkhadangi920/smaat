<?php

namespace App\GraphQL\Query\User\Role;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class RolesQuery extends BaseRoleQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}