<?php

namespace App\GraphQL\Query\Group\Category;

use App\GraphQL\Query\Group\GroupQuery;
use App\GraphQL\Helpers\AllQuery;

class CategoriesQuery extends BaseCategoryQuery
{
    use AllQuery, GroupQuery;
}