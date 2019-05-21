<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

trait DeleteMutation
{
    public function type()
    {   
        return \GraphQL::type('result');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return $this->checkPermission("delete-{$this->type}");
    }

    public function args()
    {
        return [
            'id'    => [
                'type' => $this->incrementing ? Type::int() : Type::string()
            ],
            'ids'    => [
                'type' => Type::listOf( $this->incrementing ? Type::int() : Type::string() )
            ]
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->destroy($args, $fields);
    }
}