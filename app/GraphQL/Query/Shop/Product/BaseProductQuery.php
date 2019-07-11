<?php

namespace App\GraphQL\Query\Shop\Product;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Product\ProductProps;

class BaseProductQuery extends MainQuery
{
    use ProductProps;

    protected $incrementing = false;

    protected $translatable = true;
}