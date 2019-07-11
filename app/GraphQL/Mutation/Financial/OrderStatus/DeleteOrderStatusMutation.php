<?php

namespace App\GraphQL\Mutation\Financial\OrderStatus;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteOrderStatusMutation extends BaseOrderStatusMutation
{
    use DeleteMutation;
}