<?php

namespace App\GraphQL\Mutation\Opinion\Comment;

use App\GraphQL\Helpers\ActiveMutation;

class ActiveCommentMutation extends BaseCommentMutation
{
    use ActiveMutation;

    protected $acceptable_field = 'is_accept';
}