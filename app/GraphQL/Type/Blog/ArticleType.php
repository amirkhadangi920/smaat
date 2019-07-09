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
        return [
            'is_mine' => $this->isMineField(),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'slug' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'body' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'reading_time' => [
                'type' => Type::int()
            ],
            'image' => $this->imageField('image'),
            'writer' => [
                'type' => \GraphQl::type('user'),
            ],
            'tags' => [
                'type' => Type::listOf( \GraphQl::type('tag') ),
            ],
            'votes' => $this->votes(),
            'subjects' => $this->relationListField('subject'),
            'comments' => [
                'type'  => Type::listOf( \GraphQL::type('comment') ),
                'query' => function(array $args, $query) {
                
                    if ( !$this->checkPermission('read-comment') )
                        $query->where("comments.is_accept", 1);
                        
                    $query->where('parent_id', null)
                          ->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
        
                    return $query->orderBy('created_at', 'desc');
                }
            ],
            'audits' => $this->audits('article'),
            'is_active' => $this->acceptableField('article'),
        ];
    }
}