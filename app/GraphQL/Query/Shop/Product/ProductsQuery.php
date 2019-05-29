<?php

namespace App\GraphQL\Query\Shop\Product;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ProductsQuery extends BaseProductQuery
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
            'has_advantages' => [
                'type' => Type::boolean()
            ],
            'has_disadvantages' => [
                'type' => Type::boolean()
            ],
            'has_video' => [
                'type' => Type::boolean()
            ],
            'has_reviews' => [
                'type' => Type::boolean()
            ],
            'has_table' => [
                'type' => Type::boolean()
            ],
            'has_accessory' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'units' => [
                'type' => Type::listOf( Type::int() )
            ],
            'brands' => [
                'type' => Type::listOf( Type::int() )
            ],
            'colors' => [
                'type' => Type::listOf( Type::int() )
            ],
            'sizes' => [
                'type' => Type::listOf( Type::int() )
            ],
            'warranties' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}