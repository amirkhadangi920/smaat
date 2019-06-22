<?php

namespace App\GraphQL\Query\Place\Province;

use App\GraphQL\Helpers\AllQuery;
use GraphQL\Type\Definition\Type;

class ProvincesQuery extends BaseProvinceQuery
{
    use AllQuery;

    protected $has_more_args = true;

    public function get_args()
    {
        return [
            'country' => [
                'type' => Type::nonNull( Type::int() )
            ],
        ];
    }

    public function type()
    {
        return Type::listOf( \GraphQL::type('province') );
    }

    public function getPortionOfData($data, $args)
    {
        return $data->where('country_id', $args['country'])->get();
    }
}