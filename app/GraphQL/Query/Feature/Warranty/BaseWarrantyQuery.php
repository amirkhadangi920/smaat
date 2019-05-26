<?php

namespace App\GraphQL\Query\Feature\Warranty;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Feature\WarrantyProps;

class BaseWarrantyQuery extends MainQuery
{
    use WarrantyProps;
    
    protected $translatable = true;
}