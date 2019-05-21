<?php

namespace App\GraphQL\Mutation\Feature\Brand;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Props\Feature\BrandProps;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Mutation\Feature\FeaturesCategoriesMutation;

class BaseBrandMutation extends MainMutation
{
    use BrandProps, FeaturesCategoriesMutation;
    
    protected $attributes = [
        'name' => 'ColorMutation',
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
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ]
        ];
    }
}