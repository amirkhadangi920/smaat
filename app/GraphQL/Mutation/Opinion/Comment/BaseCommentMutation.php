<?php

namespace App\GraphQL\Mutation\Opinion\Comment;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Opinion\CommentProps;

class BaseCommentMutation extends MainMutation
{
    use CommentProps;
    
    protected $attributes = [
        'name' => 'CommentMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'article_id' => [
                'type' => Type::string()
            ],
            'parent_id' => [
                'type' => Type::int()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'message' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}