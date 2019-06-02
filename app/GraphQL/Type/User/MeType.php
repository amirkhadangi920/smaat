<?php

namespace App\GraphQL\Type\User;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\User;

class MeType extends BaseType
{
    protected $incrementing = false;

    protected $attributes = [
        'name' => 'MeType',
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
            ],
            'email' => [
                'type' => Type::string(),
            ],
            'token' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'phones' => [
                'type' => Type::listOf( \GraphQL::type('user_phone') ),
            ],
            'addresses' => [
                'type' => Type::listOf( \GraphQL::type('user_address') ),
            ],
            'social_links' => [
                'type' => Type::listOf( \GraphQL::type('data_array') ),
                'is_relation' => false
            ],
            'avatar' => $this->imageField(),
            'national_code' => [
                'type' => Type::string(),
            ],
            'favorites' => $this->relationListField('product'),
            'comments' => [
                'type' => Type::listOf( \GraphQL::type("comment") ),
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'question_and_answers' => [
                'type' => Type::listOf( \GraphQL::type("question_and_answer") ),
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'reviews' => [
                'type' => Type::listOf( \GraphQL::type("review") ),
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'orders' => [
                'type' => Type::listOf( \GraphQL::type('me_order') ),
                'query' => function($args, $query) {
                    return $query->offset( (($args['page'] ?? 1 ) - 1) * 10 )->take(10);
                }
            ],
            'roles' => $this->relationListField('role'),
            'permissions' => [
                'type' => Type::listOf( \GraphQL::type('permission') )
            ],
        ];
    }
}