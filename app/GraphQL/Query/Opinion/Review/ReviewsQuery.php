<?php

namespace App\GraphQL\Query\Opinion\Review;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ReviewsQuery extends BaseReviewQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_advantages' => [
                'type' => Type::boolean()
            ],
            'has_disadvantages' => [
                'type' => Type::boolean()
            ],
            'is_accept' => [
                'type' => Type::boolean()
            ],
            'writers' => [
                'type' => Type::listOf( Type::string() )
            ],
            'products' => [
                'type' => Type::listOf( Type::string() )
            ],
        ];
    }
}