<?php

namespace App\GraphQL\Mutation\Financial\ShippingMethod;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\ShippingMethodProps;
use Rebing\GraphQL\Support\UploadType;

class BaseShippingMethodMutation extends MainMutation
{
    use ShippingMethodProps;
    
    protected $attributes = [
        'name' => 'ShippingMethodMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'name' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'cost' => [
                'type' => Type::int()
            ],
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            'minimum' => [
                'type' => Type::int()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}