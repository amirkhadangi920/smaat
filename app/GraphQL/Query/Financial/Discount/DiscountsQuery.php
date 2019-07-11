<?php

namespace App\GraphQL\Query\Financial\Discount;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class DiscountsQuery extends BaseDiscountQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_item' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'has_categories' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}