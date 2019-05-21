<?php

namespace App\GraphQL\Mutation\Opinion\Comment;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteCommentMutation extends BaseCommentMutation
{
    use DeleteMutation;
}