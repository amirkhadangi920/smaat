<?php

namespace App\GraphQL\Mutation\User\Favorite;

use App\GraphQL\Mutation\MainMutation;
use GraphQL\Type\Definition\Type;

class BaseFavoriteMutation extends MainMutation
{    
    protected $attributes = [
        'name' => 'FavoriteMutation',
        'description' => 'A mutation'
    ];
    
    public function type()
    {
        return \GraphQL::type('result');
    }

    public function args()
    {
        return [
            'product' => [
                'type' => Type::nonNull( Type::string() ),
            ],
        ];
    }
}