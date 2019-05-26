<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use OwenIt\Auditing\Models\Audit;

class VotesType extends GraphQLType
{
    protected $attributes = [
        'name' => 'VotesType',
        'description' => 'A type',
    ];

    public function fields()
    {
        return [
            'likes' => [
                'type' => Type::int()
            ],
            'dislikes' => [
                'type' => Type::int()
            ]
        ];
    }
}