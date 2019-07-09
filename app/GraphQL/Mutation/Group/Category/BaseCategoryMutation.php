<?php

namespace App\GraphQL\Mutation\Group\Category;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Props\Group\CategoryProps;
use App\GraphQL\Mutation\Group\GroupTags;

class BaseCategoryMutation extends MainMutation
{
    use CategoryProps, GroupTags;
    
    protected $attributes = [
        'name' => 'CategoryMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'parent_id' => [
                'type' => Type::int()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'icon' => [
                'type' => Type::string()
            ],
            'is_deleted_image' => [
                'type' => Type::boolean()
            ],
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            // 'scoring_feilds' => [
            //     'type' => Type::int()
            // ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
}