<?php

namespace App\GraphQL\Mutation\Group\Category;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteCategoryMutation extends BaseCategoryMutation
{
    use DeleteMutation;
}