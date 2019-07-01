<?php

namespace App\GraphQL\Query\Shop\Label;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Product\LabelProps;

class BaseLabelQuery extends MainQuery
{
    use LabelProps;

    protected $translatable = true;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-label');
    }
}