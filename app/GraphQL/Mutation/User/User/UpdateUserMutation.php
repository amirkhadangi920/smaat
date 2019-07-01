<?php

namespace App\GraphQL\Mutation\User\User;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateUserMutation extends BaseUserMutation
{
    use UpdateMutation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return auth()->id() === $args['id'] || $this->checkPermission("update-user");
    }
}