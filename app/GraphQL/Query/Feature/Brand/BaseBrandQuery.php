<?php

namespace App\GraphQL\Query\Feature\Brand;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Feature\BrandProps;

class BaseBrandQuery extends MainQuery
{
    use BrandProps;
    
    protected $translatable = true;
}