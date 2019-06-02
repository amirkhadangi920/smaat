<?php

namespace App\GraphQL\Type\Opinion;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Opinion\Review;

class ReviewType extends BaseType
{
    protected $attributes = [
        'name' => 'ReviewType',
        'description' => 'A type',
        'model' => Review::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('review'),
            'ranks' => [
                'type' => Type::listOf( \GraphQL::type('scoring_field') )
            ],
            'advantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'message' => [
                'type' => Type::string()
            ],
            'writer' => [
                'type' => \GraphQL::type('user'),
            ],
            'votes' => $this->votes(),
            'product' => $this->relationItemField('product'),
            'audits' => $this->audits('review'),
            'is_accept' => $this->acceptableField('review'),
        ];
    }
}