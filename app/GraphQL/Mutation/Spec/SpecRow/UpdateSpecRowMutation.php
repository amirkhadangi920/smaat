<?php

namespace App\GraphQL\Mutation\Spec\SpecRow;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateSpecRowMutation extends BaseSpecRowMutation
{
    use UpdateMutation;

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getModel($data)
    {
        return $this->model::findOrFail($data);
    }
}