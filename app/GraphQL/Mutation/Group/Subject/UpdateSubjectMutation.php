<?php

namespace App\GraphQL\Mutation\Group\Subject;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateSubjectMutation extends BaseSubjectMutation
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