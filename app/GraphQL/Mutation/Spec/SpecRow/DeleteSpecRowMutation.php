<?php

namespace App\GraphQL\Mutation\Spec\SpecRow;

use App\GraphQL\Helpers\DeleteMutation;
use App\GraphQL\Helpers\DeleteWithoutTenant;

class DeleteSpecRowMutation extends BaseSpecRowMutation
{
    use DeleteMutation, DeleteWithoutTenant;
}