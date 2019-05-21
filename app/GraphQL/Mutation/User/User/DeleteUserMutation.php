<?php

namespace App\GraphQL\Mutation\User\User;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteUserMutation extends BaseUserMutation
{
    use DeleteMutation;
}