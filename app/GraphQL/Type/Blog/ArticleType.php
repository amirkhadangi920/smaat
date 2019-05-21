<?php

namespace App\GraphQL\Type\Blog;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Article;
use function GuzzleHttp\json_encode;

class ArticleType extends BaseType
{
    public $incrementing = false;
    
    protected $attributes = [
        'name' => 'ArticleType',
        'description' => 'A type',
        'model' => Article::class
    ];

    public function get_fields()
    {
        return $this->infoField() + [
            'is_mine' => $this->isMineField(),
            'body' => [
                'type' => Type::string()
            ],
            'reading_time' => [
                'type' => Type::int()
            ],
            'image' => $this->imageField(),
            'user' => [
                'type' => \GraphQl::type('user'),
            ],
            'tags' => [
                'type' => Type::listOf( \GraphQl::type('tag') ),
            ],
            'subjects' => $this->relationListField('subject'),
            'comments' => $this->relationListField('comment', 'is_accept'),
            'audits' => $this->audits('article'),
            'is_active' => $this->acceptableField('article'),
        ];
    }
}