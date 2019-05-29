<?php

namespace App\GraphQL\Query\Feature\Size;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class SizesQuery extends BaseSizeQuery
{
    use AllQuery;
    
    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_categories' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}