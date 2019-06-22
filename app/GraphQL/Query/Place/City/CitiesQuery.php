<?php

namespace App\GraphQL\Query\Place\City;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class CitiesQuery extends BaseCityQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'province' => [
                'type' => Type::nonNull( Type::int() )
            ],
        ];
    }

    public function type()
    {
        return Type::listOf( \GraphQL::type('city') );
    }

    public function getPortionOfData($data, $args)
    {
        return $data->where('province_id', $args['province'])->get();
    }
}