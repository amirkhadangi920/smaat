<?php

namespace App\GraphQL\Query\Opinion\Comment;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class CommentsQuery extends BaseCommentQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'has_answer' => [
                'type' => Type::boolean()
            ],
            'is_accept' => [
                'type' => Type::boolean()
            ],
            'writers' => [
                'type' => Type::listOf( Type::string() )
            ],
            'articles' => [
                'type' => Type::listOf( Type::string() )
            ],
        ];
    }
}