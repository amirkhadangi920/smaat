<?php

namespace App\GraphQL\Mutation\Spec\SpecDefault;

use App\GraphQL\Helpers\DeleteMutation;
use App\GraphQL\Helpers\DeleteWithoutTenant;

class DeleteSpecDefaultMutation extends BaseSpecDefaultMutation
{
    use DeleteMutation, DeleteWithoutTenant;
}