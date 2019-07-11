<?php

namespace App\GraphQL\Query\Opinion\Comment;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Opinion\CommentProps;

class BaseCommentQuery extends MainQuery
{
    use CommentProps;

    protected $acceptable = false;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-comment');
    }

    public function applyFilters($args, $data)
    {
        $data->where('parent_id', null);
    }
}