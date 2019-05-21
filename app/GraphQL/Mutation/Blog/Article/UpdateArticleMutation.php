<?php

namespace App\GraphQL\Mutation\Blog\Article;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateArticleMutation extends BaseArticleMutation
{
    use UpdateMutation;
}