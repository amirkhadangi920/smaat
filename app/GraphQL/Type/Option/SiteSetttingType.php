<?php

namespace App\GraphQL\Type\Option;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class SiteSettingType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SiteSetting',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'title' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data['title'] ?? 'فروشگاه اینترنتی';
                }
            ],
            'description' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data['description'] ?? 'فروشگاه اینترنتی قدرت گرفته از سیستم SmaaT shop';
                }
            ],
            'phone' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data['phone'] ?? '09105009868';
                }
            ],
            'address' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data['address'] ?? 'خراسان رضوی ، مشهد ، سناباد ۴۴ ، ساختمان ۵۲ ، واحد ۷';
                }
            ],
            'is_enabled' => [
                'type' => Type::boolean(),
                'resolve' => function($data) {
                    return $data['is_enabled'] ?? true;
                }
            ],
            'is_enabled' => [
                'type' => Type::boolean(),
                'resolve' => function($data) {
                    return $data['is_enabled'] ?? true;
                }
            ],
            'logo' => [
                'type' => \GraphQL::type('image'),
                'resolve' => function($data) {
                    return $data['image'] ?? [
                        'tiny' => '/images/site_logo/tiny.png',
                        'small' => '/images/site_logo/small.png',
                        'medium' => '/images/site_logo/medium.png',
                        'big' => '/images/site_logo/big.png',
                    ];
                }
            ],
            'theme_color' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data['theme_color'] ?? '#500045';
                }
            ],
        ];
    }
}