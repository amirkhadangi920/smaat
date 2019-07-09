<?php

namespace App\GraphQL\Mutation\Spec\SpecHeader;

use App\GraphQL\Helpers\UpdateMutation;

class UpdateSpecHeaderMutation extends BaseSpecHeaderMutation
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