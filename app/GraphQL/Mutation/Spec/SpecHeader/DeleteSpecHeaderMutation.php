<?php

namespace App\GraphQL\Mutation\Spec\SpecHeader;

use App\GraphQL\Helpers\DeleteMutation;
use App\GraphQL\Helpers\DeleteWithoutTenant;

class DeleteSpecHeaderMutation extends BaseSpecHeaderMutation
{
    use DeleteMutation, DeleteWithoutTenant;
}