<?php

namespace App\GraphQL\Query\Place\Country;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class CountriesQuery extends BaseCountryQuery
{
    use AllQuery;

    public function type()
    {
        return Type::listOf( \GraphQL::type('country') );
    }

    public function getPortionOfData($data, $args)
    {
        return $data->get();
    }
}