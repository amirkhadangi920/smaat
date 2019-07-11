<?php

namespace App\GraphQL\Query\User\User;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class UsersQuery extends BaseUserQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'national_code' => [
                'type' => Type::string()
            ],
            'cities' => [
                'type' => Type::string()
            ],
        ];
    }
}