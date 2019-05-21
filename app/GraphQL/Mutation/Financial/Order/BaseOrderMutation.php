<?php

namespace App\GraphQL\Mutation\Financial\Order;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\OrderProps;

class BaseOrderMutation extends MainMutation
{
    use OrderProps;
    
    protected $attributes = [
        'name' => 'OrderMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            // 'name' => [
            //     'type' => Type::string()
            // ],
            // 'description' => [
            //     'type' => Type::string()
            // ],
            // 'cost' => [
            //     'type' => Type::int()
            // ],
            // 'logo' => [
            //     'type' => UploadType::getInstance()
            // ],
            // 'minimum' => [
            //     'type' => Type::int()
            // ],
            // 'is_active' => [
            //     'type' => Type::boolean()
            // ]
        ];
    }
}