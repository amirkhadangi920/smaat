<?php

namespace App\GraphQL\Query\Group;

trait GroupQuery
{
    public function applyFilters($args, $data)
    {
        $data->where('parent_id', null);
    }
}