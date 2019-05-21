<?php

namespace App\GraphQL\Props\Opinion;

use App\Models\Opinion\Comment;
use App\Http\Resources\Opinion\Comment as CommentResource;
use App\ModelFilters\Opinion\CommentFilter;
use App\Http\Requests\v1\Opinion\CommentRequest;
use App\Http\Resources\Opinion\CommentCollection;

trait CommentProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'comment';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Comment::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'article:id,title,image',
        'user:id,first_name,last_name,avatar',
        'answers:id,parent_id,user_id,message,is_accept,created_at,updated_at',
        'answers.user:id,first_name,last_name,avatar'
    ];

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'comments';

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = CommentResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = CommentCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = CommentFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = CommentRequest::class;
}