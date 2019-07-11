<?php

namespace App\GraphQL\Mutation\Financial\OrderStatus;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\OrderStatusProps;

class BaseOrderStatusMutation extends MainMutation
{
    use OrderStatusProps;
    
    protected $attributes = [
        'name' => 'OrderStatusMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'color' => [
                'type' => Type::string()
            ],
            'icon' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}