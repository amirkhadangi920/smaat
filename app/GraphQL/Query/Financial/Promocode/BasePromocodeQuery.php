<?php

namespace App\GraphQL\Query\Financial\Promocode;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Financial\PromocdeProps;

class BasePromocodeQuery extends MainQuery
{
    use PromocdeProps;

    public function authorize(array $args)
    {
        return $this->checkPermission('read-promocode');
    }
}