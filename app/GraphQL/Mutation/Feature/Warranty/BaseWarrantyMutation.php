<?php

namespace App\GraphQL\Mutation\Feature\Warranty;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Props\Feature\SizeProps;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Mutation\Feature\FeaturesCategoriesMutation;

class BaseWarrantyMutation extends MainMutation
{
    use SizeProps, FeaturesCategoriesMutation;

    protected $attributes = [
        'name' => 'WarrantyMutation',
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
            'expire' => [
                'type' => Type::string()
            ],
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ]
        ];
    }
}