<?php

namespace App\GraphQL\Query\Group\Category;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Group\CategoryProps;

class BaseCategoryQuery extends MainQuery
{
    use CategoryProps;
    
    protected $translatable = true;
}