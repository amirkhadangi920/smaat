<?php

namespace App\GraphQL\Mutation\Opinion\Review;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteReviewMutation extends BaseReviewMutation
{
    use DeleteMutation;
}