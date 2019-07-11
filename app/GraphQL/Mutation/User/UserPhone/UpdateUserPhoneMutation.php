<?php

namespace App\GraphQL\Mutation\User\UserPhone;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateUserPhoneMutation extends BaseUserPhoneMutation
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