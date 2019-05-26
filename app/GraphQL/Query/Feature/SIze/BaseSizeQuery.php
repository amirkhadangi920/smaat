<?php

namespace App\GraphQL\Query\Feature\Size;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Feature\SizeProps;

class BaseSizeQuery extends MainQuery
{
    use SizeProps;
    
    protected $translatable = true;
}