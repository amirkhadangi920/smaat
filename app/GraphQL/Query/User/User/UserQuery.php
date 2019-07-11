<?php

namespace App\GraphQL\Query\User\User;

use App\GraphQL\Helpers\SingleQuery;
use GraphQL\Type\Definition\Type;

class UserQuery extends BaseUserQuery
{
    use SingleQuery;

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull( $this->incrementing ? Type::int() : Type::string() )
            ],
            'page' => [
                'type' => Type::int()
            ]
        ];
    }
}