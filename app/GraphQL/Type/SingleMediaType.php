<?php

namespace App\GraphQL\Type;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class SingleMediaType extends GraphQLType
{
    protected $attributes = [
        'name' => 'SingleMedia',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
            'name' => [
                'type' => Type::string(),
            ],
            'file_name' => [
                'type' => Type::string(),
            ],
            'size' => [
                'type' => Type::string(),
            ],
            'mime_type' => [
                'type' => Type::string(),
            ],
            'custom_properties' => [
                'type' => \GraphQL::type('media_custom_properties'),
                'is_relation' => false
            ],
            'thumb' => $this->imageType('thumb'),
            'small' => $this->imageType('small'),
            'medium' => $this->imageType('medium'),
            'large' => $this->imageType('large'),
            'wide' => $this->imageType('wide'),
        ];
    }

    public function imageType($type)
    {
        return [
            'type' => Type::string(),
            'selectable' => false,
            'resolve' => function($image) use($type) {
                return $this->getUrl($image, $type);
            }
        ];
    }

    public function getUrl($image, $type)
    {
        $file = pathinfo($image->file_name ?? $image->name);

        $ext = $file['extension'] ?? 'jpg';
                    
        return "/uploads/images/{$image->id}/conversions/{$file['filename']}-{$type}.{$ext}";
    }
}