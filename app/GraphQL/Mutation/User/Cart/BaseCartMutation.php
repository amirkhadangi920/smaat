<?php

namespace App\GraphQL\Mutation\User\Cart;

use App\GraphQL\Mutation\MainMutation;
use GraphQL\Type\Definition\Type;

class BaseCartMutation extends MainMutation
{    
    protected $attributes = [
        'name' => 'CartMutation',
        'description' => 'A mutation'
    ];
    
    public function type()
    {
        return \GraphQL::type('result');
    }

    public function getArgs()
    {
        return [
            'variation' => [
                'type' => Type::nonNull( Type::string() ),
            ],
            'quantity' => [
                'type' => Type::int()
            ]
        ];
    }

    /**
     * Find the unpaid order of the current user
     * or create new one for him
     *
     * @return void
     */
    public function getCart()
    {
        return auth()->user()->orders()->firstOrCreate([
            'order_status_id'   => 1
        ], [
            'city_id'           => auth()->user()->city_id,
            'destination'       => auth()->user()->address,
            'postal_code'       => auth()->user()->postal_code
        ]);
    }
}