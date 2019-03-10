<?php

namespace App\Http\Controllers\API\v1\Opinion;

use App\Models\Opinion\Comment;
use App\Http\Resources\Opinion\Comment as CommentResource;

class CommentController extends OpinionBaseController
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
        'article:id,slug,title',
        'user:id,first_name,last_name,avatar',
        'answers:id,parent_id,user_id,message,created_at',
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
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::select('id', 'parent_id', 'user_id', 'message', 'created_at')
            ->whereNull('parent_id')
            ->with($this->relations)
            ->latest()
            ->paginate( $this->getPerPage() );
    }
}
