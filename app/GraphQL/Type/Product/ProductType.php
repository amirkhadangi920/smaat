<?php

namespace App\GraphQL\Type\Product;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Product\Product;

class ProductType extends BaseType
{
    public $incrementing = false;
    
    protected $attributes = [
        'name' => 'ProductType',
        'description' => 'A type',
        'model' => Product::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('product'),
            'name' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'second_name' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'code' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'aparat_video' => [
                'type' => Type::string()
            ],
            'review' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'advantages' => [
                'type' => Type::listOf( Type::string() ),
                'selectable' => false
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() ),
                'selectable' => false
            ],
            'photos' => [
                'type' => Type::listOf( \GraphQL::type('image') ),
                'is_relation' => false
            ],
            'views_count' => [
                'type' => Type::int()
            ],
            'votes' => $this->votes(),
            'variations' => $this->relationListField('variation', 'is_active', 'read-product'),
            'variation' => $this->relationItemField('variation', 'is_active', 'read-product'),
            'spec' => $this->relationItemField('specification'),
            'brand' => $this->relationItemField('brand'),
            'category' => $this->relationItemField('category'),
            'unit' => $this->relationItemField('unit'),
            // TODO => need a improvment
            'reviews' => $this->relationListField('review'),
            // TODO => need a improvment
            'questions' => $this->relationListField('question_and_answer'),
            // TODO => need a improvment
            'accessories' => $this->relationListField('product'),
            'audits' => $this->audits('product'),
            'is_active' => $this->acceptableField('product')
        ];
    }
}