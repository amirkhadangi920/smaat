<?php

namespace App\GraphQL\Mutation\Product\Product;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteProductMutation extends BaseProductMutation
{
    use DeleteMutation;
}