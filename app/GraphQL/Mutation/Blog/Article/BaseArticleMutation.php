<?php

namespace App\GraphQL\Mutation\Blog\Article;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Blog\ArticleProps;

class BaseArticleMutation extends MainMutation
{
    use ArticleProps;
    
    protected $attributes = [
        'name' => 'ArticleMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'body' => [
                'type' => Type::string()
            ],
            'image' => [
                'type' => UploadType::getInstance()
            ],
            'reading_time' => [
                'type' => Type::int()
            ],
            'subjects' => [
                'type' => Type::listOf( Type::int() )
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}