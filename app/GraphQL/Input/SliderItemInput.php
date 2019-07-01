<?php

namespace App\GraphQL\Input;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\UploadType;

class SliderItemInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'SliderItemInput',
        'description' => 'A type'
    ];

    public function fields()
    {
        return [
            'image' => [
                'type' => UploadType::getInstance()
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'button' => [
                'type' => Type::string()
            ],
            'link' => [
                'type' => Type::string()
            ],
        ];
    }
}