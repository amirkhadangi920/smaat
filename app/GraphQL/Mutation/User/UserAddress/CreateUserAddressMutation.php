<?php

namespace App\GraphQL\Mutation\User\UserAddress;

use App\GraphQL\Helpers\CreateMutation;

class CreateUserAddressMutation extends BaseUserAddressMutation
{
    use CreateMutation;

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