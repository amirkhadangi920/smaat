<?php

namespace App\GraphQL\Mutation\Feature\Color;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteColorMutation extends BaseColorMutation
{
    use DeleteMutation;
}