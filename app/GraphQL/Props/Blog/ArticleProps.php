<?php

namespace App\GraphQL\Props\Blog;

use App\Models\Article;
use App\ModelFilters\Blog\ArticleFilter;
use App\Http\Resources\Blog\Article as ArticleResource;
use App\Http\Requests\v1\Article\ArticleRequest;
use App\Http\Resources\Blog\ArticleCollection;

trait ArticleProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'article';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Article::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'subjects',
        'user:id:first_name,last_name'
    ];

    protected $more_relations = [
        'tags:name,slug'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ArticleResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = ArticleCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ArticleFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'image';

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = ArticleRequest::class;
}