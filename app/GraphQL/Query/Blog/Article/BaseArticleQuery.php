<?php

namespace App\GraphQL\Query\Blog\Article;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Blog\ArticleProps;

class BaseArticleQuery extends MainQuery
{
    protected $incrementing = false;

    use ArticleProps;
}