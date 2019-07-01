<?php

namespace App\GraphQL\Input;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\UploadType;

class ImageColorInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'ImageColorInput',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'color' => [
                'type' => Type::int()
            ],
            'image' => [
                'type' => UploadType::getInstance()
            ]
        ];
    }
}