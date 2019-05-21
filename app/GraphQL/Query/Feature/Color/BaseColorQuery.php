<?php

namespace App\GraphQL\Query\Feature\Color;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Feature\ColorProps;

class BaseColorQuery extends MainQuery
{
    use ColorProps;
}