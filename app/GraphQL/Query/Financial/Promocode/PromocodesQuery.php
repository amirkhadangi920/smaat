<?php

namespace App\GraphQL\Query\Financial\Promocode;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class PromocodesQuery extends BasePromocodeQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'code' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'is_expired' => [
                'type' => Type::boolean()
            ],
            'has_users' => [
                'type' => Type::boolean()
            ],
            'users' => [
                'type' => Type::listOf( Type::string() )
            ],
            'has_category' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'has_variation' => [
                'type' => Type::boolean()
            ],
            'variations' => [
                'type' => Type::listOf( Type::string() )
            ],
        ];
    }
}