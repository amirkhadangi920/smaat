<?php

namespace App\GraphQL\Query\Blog\Article;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Blog\ArticleProps;

class BaseArticleQuery extends MainQuery
{
    use ArticleProps;
    
    protected $incrementing = false;
    
    protected $translatable = true;
}