<?php

namespace App\GraphQL\Query\Shop\Spec;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class SpecsQuery extends BaseSpecQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_header' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'has_row' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}