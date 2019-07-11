<?php

namespace App\GraphQL\Type\Option;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use function GuzzleHttp\json_decode;

class SiteSettingType extends BaseType
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
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'phone' => [
                'type' => Type::string(),
            ],
            'address' => [
                'type' => Type::string(),
            ],
            'banner_link' => [
                'type' => Type::string(),
            ],
            'logo' => $this->imageField('logo'),
            'banner' => $this->imageField('banner'),
            'header_banner' => $this->imageField('header_banner'),
            'watermark' => $this->imageField('watermark'),
            'theme_color' => [
                'type' => Type::string(),
            ],
            'is_enabled' => [
                'type' => Type::boolean(),
                'resolve' => function($data) {                    
                    return is_null( $data['is_enabled'] ?? null ) ? true : $data['is_enabled'];
                }
            ],
            'slider' => $this->slider('slider'),
            'posters' => $this->slider('posters'),
        ];
    }

    public function imageField($field = 'logo')
    {
        return [
            'type' => \GraphQL::type('single_media'),
            'is_relation' => false,
            'resolve' => function($data) use($field) {
                return $data[ $field ][0] ?? null;
            }
        ];
    }

    public function slider($type)
    {
        return [
            'type' => Type::listOf( \GraphQL::type('slider_item') ),
            'is_relation' => false,
            'resolve' => function($data) use($type) {
                $slider = json_decode( $data[ $type ]['value'] ?? '[]' );
                
                foreach ( $slider as $slide )
                    $slide->image = $data[ $type ]->media->where('id', $slide->image ?? null)->first();

                return $slider;
            }
        ];
    }
}