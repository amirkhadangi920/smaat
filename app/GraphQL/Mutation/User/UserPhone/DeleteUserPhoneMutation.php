<?php

namespace App\GraphQL\Mutation\User\UserPhone;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteUserPhoneMutation extends BaseUserPhoneMutation
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