<?php

namespace App\GraphQL\Mutation\Group;

trait GroupTags
{
    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $group
     * @return void
     */
    public function afterCreate($request, $group)
    {
        $group->attachTags($request->keywords);
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $group
     * @return void
     */
    public function afterUpdate($request, $group)
    {
        $group->syncTags($request->keywords);
    }
}