<?php

namespace App\GraphQL\Mutation\Opinion\Review;

use App\GraphQL\Helpers\CreateMutation;

class CreateReviewMutation extends BaseReviewMutation
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
        $request->put('is_accept', auth()->user()->can("accept-{$this->type}"));

        return $request->all();
    }
}