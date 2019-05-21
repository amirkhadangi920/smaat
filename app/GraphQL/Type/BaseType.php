<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use App\Traits\CheckPermissions;
use Illuminate\Support\Str;

class BaseType extends GraphQLType
{
    use CheckPermissions;

    public function fields()
    {
        return array_merge(
            [
                'id' => [
                    'type' => $this->incrementing ?? true ? Type::int() : Type::string()
                ],
                'created_at' => [
                    'type' => Type::string()
                ],
                'updated_at' => [
                    'type' => Type::string()
                ]
            ],
            
            $this->get_fields()
        );
    }

    public function infoField(String $field = 'title')
    {
        return [
            $field => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ]
        ];
    }

    public function audits($type)
    {
        return [
            'type' => Type::listOf( \GraphQL::type('audit') ),
            'query' => function(array $args, $query) {
                return $query->orderBy('created_at', 'desc')->limit(5);
            },
            'privacy' => function() use($type) {
                return $this->checkPermission("see-log-{$type}");
            }
        ];
    }

    public function creator($type)
    {
        return [
            'type' => \GraphQL::type('user'),
            'privacy' => function() use($type) {
                return $this->checkPermission("see-creator-{$type}");
            }
        ];
    }

    public function relationListField($type, $acceptable_field = 'is_active', $permission = null)
    {
        return [
            'type'  => Type::listOf( \GraphQL::type($type) ),
            'query' => $this->getRelationQuery($type, $acceptable_field, $permission)
        ];
    }

    public function relationItemField($type, $acceptable_field = 'is_active', $permission = null)
    {
        return [
            'type'  => \GraphQL::type($type),
            'query' => $this->getRelationQuery($type, $acceptable_field, $permission)
        ];
    }

    public function getRelationQuery($type, $acceptable_field, $permission = null)
    {
        $permission = $permission ? $permission : "read-{$type}";

        return function(array $args, $query) use($type, $acceptable_field, $permission) {
                
            if ( !$this->checkPermission($permission) )
                return $query->where(Str::plural($type) . ".{$acceptable_field}", 1);

            return $query;
        };
    }

    public function acceptableField($type)
    {
        return [
            'type' => Type::boolean(),
            'privacy' => function() use($type) {
                return $this->checkPermission("read-{$type}");
            }
        ];
    }

    public function imageField()
    {
        return [
            'type' => \GraphQl::type('image'),
            'is_relation' => false
        ];
    }

    public function isMineField()
    {
        return [
            'type' => Type::boolean(),
            'resolve' => function($data) {
                return $data->user_id === auth()->user()->id ?? false;
            }
        ];
    }
}