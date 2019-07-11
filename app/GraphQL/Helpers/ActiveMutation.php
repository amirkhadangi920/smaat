<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Illuminate\Support\Str;

trait ActiveMutation
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
        $active_type = Str::replaceFirst('is_', '', $this->acceptable_field);

        return $this->checkPermission("{$active_type}-". ($this->permission_label ? $this->permission_label : $this->type));
    }

    public function args()
    {
        return [
            'id'        => [
                'type' => $this->incrementing ? Type::int() : Type::string()
            ],
            'ids'       => [
                'type' => Type::listOf( $this->incrementing ? Type::int() : Type::string() )
            ],
            'status'    => [
                'type' => Type::nonNull( Type::boolean() ),
            ]
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->active($args, $fields);
    }
}