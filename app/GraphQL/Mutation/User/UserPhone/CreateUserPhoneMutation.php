<?php

namespace App\GraphQL\Mutation\User\UserPhone;

use App\GraphQL\Helpers\CreateMutation;

class CreateUserPhoneMutation extends BaseUserPhoneMutation
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