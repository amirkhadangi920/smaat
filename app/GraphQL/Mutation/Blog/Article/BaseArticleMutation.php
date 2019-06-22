<?php

namespace App\GraphQL\Mutation\Blog\Article;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Blog\ArticleProps;

class BaseArticleMutation extends MainMutation
{
    use ArticleProps;

    protected $incrementing = false;
    
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
            'tags' => [
                'type' => Type::listOf( Type::string() )
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $article)
    {
        $article->subjects()->attach( $request->get('subjects') );
        $article->attachTags( $request->get('tags') );
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterUpdate($request, $article)
    {
        $article->subjects()->sync( $request->get('subjects') );
        $article->syncTags( $request->get('tags') );
    }
}