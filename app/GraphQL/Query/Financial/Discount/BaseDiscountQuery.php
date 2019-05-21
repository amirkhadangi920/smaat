<?php

namespace App\GraphQL\Query\Financial\Discount;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Financial\DiscountProps;

class BaseDiscountQuery extends MainQuery
{
    use DiscountProps;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-discount');
    }
}