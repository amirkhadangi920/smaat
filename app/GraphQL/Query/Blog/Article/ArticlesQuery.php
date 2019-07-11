<?php

namespace App\GraphQL\Query\Blog\Article;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ArticlesQuery extends BaseArticleQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_subject' => [
                'type' => Type::boolean()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'min_reading_time' => [
                'type' => Type::int()
            ],
            'reading_time' => [
                'type' => Type::listOf( Type::int() )
            ],
            'writers' => [
                'type' => Type::listOf( Type::string() )
            ],
            'subjects' => [
                'type' => Type::listOf( Type::int() )
            ],
        ];
    }
}