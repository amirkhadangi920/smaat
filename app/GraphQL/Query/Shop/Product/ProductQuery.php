<?php

namespace App\GraphQL\Query\Shop\Product;

use App\GraphQL\Helpers\SingleQuery;
use GraphQL\Type\Definition\Type;

class ProductQuery extends BaseProductQuery
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