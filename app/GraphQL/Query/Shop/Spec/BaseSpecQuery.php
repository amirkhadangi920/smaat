<?php

namespace App\GraphQL\Query\Shop\Spec;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Spec\SpecProps;

class BaseSpecQuery extends MainQuery
{
    use SpecProps;

    protected $acceptable = false;

    protected $translatable = true;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-spec');
    }
}