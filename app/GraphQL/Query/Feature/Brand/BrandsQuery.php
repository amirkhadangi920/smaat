<?php

namespace App\GraphQL\Query\Feature\Brand;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class BrandsQuery extends BaseBrandQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_logo' => [
                'type' => Type::boolean()
            ],
            'has_categories' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'category' => [
                'type' => Type::int()
            ],
        ];
    }
}