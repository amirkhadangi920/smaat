<?php

namespace App\GraphQL\Query\User\User;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class MeQuery extends BaseUserQuery
{
    public function type()
    {   
        return \GraphQL::type('me');
    }
    
    public function args()
    {
        return [
            'page' => [
                'type' => Type::int()
            ]
        ];
    }
    
    public function authorize(array $args)
    {
        return true;
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->getSingleData([ 'id' => auth()->user()->id ], $fields);
    }
}