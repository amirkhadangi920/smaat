<?php

namespace App\GraphQL\Type\Opinion;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Opinion\Comment;

class CommentType extends BaseType
{
    protected $attributes = [
        'name' => 'CommentType',
        'description' => 'A type',
        'model' => Comment::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('comment'),
            'title' => [
                'type' => Type::string()
            ],
            'message' => [
                'type' => Type::string()
            ],
            'writer' => [
                'type' => \GraphQL::type('user'),
            ],
            'votes' => $this->votes(),
            'article' => $this->relationItemField('article'),
            'question' => $this->relationItemField('comment', 'is_accept'),
            'answers' => $this->relationListField('comment', 'is_accept'),
            'audits' => $this->audits('comment'),
            'is_accept' => [
                'type' => Type::boolean(),
            ],
        ];
    }
}