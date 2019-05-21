<?php

namespace App\GraphQL\Mutation\Blog\Article;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteArticleMutation extends BaseArticleMutation
{
    use DeleteMutation;
}