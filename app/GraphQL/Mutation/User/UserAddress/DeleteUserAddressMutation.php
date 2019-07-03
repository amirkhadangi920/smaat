<?php

namespace App\GraphQL\Mutation\User\UserAddress;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteUserAddressMutation extends BaseUserAddressMutation
{
    use DeleteMutation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return true;
    }
}