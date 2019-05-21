<?php

namespace App\GraphQL\Mutation\Financial\Order;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteOrderMutation extends BaseOrderMutation
{
    use DeleteMutation;
}