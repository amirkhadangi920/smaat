<?php

namespace App\GraphQL\Mutation\Group\Category;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateCategoryMutation extends BaseCategoryMutation
{
    use UpdateMutation;

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest($request)
    {
        return $request->except('parent_id')->all();
    }
}