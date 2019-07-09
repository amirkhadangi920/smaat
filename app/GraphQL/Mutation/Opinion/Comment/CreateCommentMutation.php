<?php

namespace App\GraphQL\Mutation\Opinion\Comment;

use App\GraphQL\Helpers\CreateMutation;

class CreateCommentMutation extends BaseCommentMutation
{
    use CreateMutation;

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        $request->put('is_accept', auth()->user()->can("-{$this->type}"));

        return $request->all();
    }
}