<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

trait SingleQuery
{
    public function type()
    {   
        return \GraphQL::type( $this->type );
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull( $this->incrementing ? Type::int() : Type::string() )
            ]
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {   
        return $this->getSingleData($args, $fields);
    }
}