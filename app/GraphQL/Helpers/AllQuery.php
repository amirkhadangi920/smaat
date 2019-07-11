<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

trait AllQuery
{
    public function type()
    {
        return \GraphQL::paginate( $this->type );
    }

    public function args()
    {
        return array_merge( $this->has_more_args ?? false ? $this->get_args() : [], [
            'per_page' => [
                'type' => Type::int()
            ],
            'page' => [
                'type' => Type::int()
            ],
            'query' => [
                'type' => Type::string()
            ],
            'ordering' => [
                'type' => Type::string()
            ],
            'ids' => [
                'type' => Type::listOf( $this->incrementing ? Type::int() : Type::string() )
            ]
        ]);
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->getAllData($args, $fields);
    }
}