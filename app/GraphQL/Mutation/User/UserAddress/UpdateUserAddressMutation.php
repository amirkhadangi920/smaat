<?php

namespace App\GraphQL\Mutation\User\UserAddress;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateUserAddressMutation extends BaseUserAddressMutation
{
    use UpdateMutation;

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