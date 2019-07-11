<?php

namespace App\GraphQL\Mutation\Opinion\Review;

use App\GraphQL\Helpers\ActiveMutation;

class ActiveReviewMutation extends BaseReviewMutation
{
    use ActiveMutation;

    protected $acceptable_field = 'is_accept';
}