<?php

namespace App\GraphQL\Query\Shop\Product;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Product\ProductProps;

class BaseProductQuery extends MainQuery
{
    protected $incrementing = false;

    use ProductProps;
}