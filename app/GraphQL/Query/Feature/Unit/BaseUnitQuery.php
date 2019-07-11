<?php

namespace App\GraphQL\Query\Feature\Unit;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Feature\UnitProps;

class BaseUnitQuery extends MainQuery
{
    use UnitProps;

    protected $translatable = true;
}