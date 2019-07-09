<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\User;

class UserType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'UserType',
        'description' => 'A type',
        'model' => User::class
    ];

    public function get_fields()
    {
        return [
            'first_name' => [
                'type' => Type::string()
            ],
            'last_name' => [
                'type' => Type::string()
            ],
            'full_name' => [
                'type' => Type::string(),
                'resolve'       => function ($data) {
                    return $data->full_name;
                },
                'selectable'    => false,
            ],
            'city' => [
                'type' => \GraphQL::type('city'),
                'privacy' => function() {
                    return $this->checkPermission("see-address-user");
                },
            ],
            'email' => [
                'type' => Type::string(),
                'privacy' => function($data) {
                    return $this->checkPermission("see-details-user");
                },
            ],
            'phones' => [
                'type' => Type::listOf( \GraphQL::type('user_phone') ),
                'privacy' => function() {
                    return $this->checkPermission("see-phone-number-user");
                },
            ],
            'addresses' => [
                'type' => Type::listOf( \GraphQL::type('user_address') ),
                'privacy' => function() {
                    return $this->checkPermission("see-address-user");
                },
            ],
            'social_links' => [
                'type' => Type::listOf( \GraphQL::type('data_array') ),
                'privacy' => function() {
                    return $this->checkPermission("see-details-user");
                },
                'is_relation' => false
            ],
            'avatar' => $this->imageField('avatar'),
            'national_code' => [
                'type' => Type::string(),
                'privacy' => function() {
                    return $this->checkPermission("see-details-user");
                },
            ],
            'gender' => [
                'type' => Type::boolean(),
            ],
            'favorites' => $this->relationListField('product'),
            'comments' => [
                'type' => Type::listOf( \GraphQL::type("comment") ),
                'privacy' => function() {
                    return $this->checkPermission("read-comment");
                },
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'question_and_answers' => [
                'type' => Type::listOf( \GraphQL::type("question_and_answer") ),
                'privacy' => function() {
                    return $this->checkPermission("read-question_and_answer");
                },
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'reviews' => [
                'type' => Type::listOf( \GraphQL::type("review") ),
                'privacy' => function() {
                    return $this->checkPermission("read-review");
                },
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'orders' => [
                'type' => Type::listOf( \GraphQL::type('order') ),
                'privacy' => function() {
                    return $this->checkPermission("read-order");
                },
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'roles' => $this->relationListField('role'),
            'permissions' => [
                'type' => Type::listOf( \GraphQL::type('permission') )
            ],
            'used_at' => [
                'type' => Type::string(),
                'selectable' => false,
                'resolve' => function($data) {
                    return $data->pivot->used_at ?? null;
                }
            ],
            'audits' => $this->audits('user'),
        ];
    }
}