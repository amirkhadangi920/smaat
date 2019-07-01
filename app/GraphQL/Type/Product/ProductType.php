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
                'type' => Type::listOf( Type::string() ),
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
            'short_review' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'expert_review' => [
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
                'type' => Type::listOf( \GraphQL::type('single_media') ),
            ],
            'views_count' => [
                'type' => Type::int()
            ],
            'tags' => [
                'type' => Type::listOf( \GraphQl::type('tag') ),
            ],
            'votes' => $this->votes(),
            'variations' => $this->relationListField('variation', 'is_active', 'read-product'),
            'variation' => $this->relationItemField('variation', 'is_active', 'read-product'),
            'spec' => $this->relationItemField('spec'),
            'brand' => $this->relationItemField('brand'),
            'label' => $this->relationItemField('label'),
            'categories' => $this->relationListField('category'),
            'colors' => $this->relationListField('color'),
            'unit' => $this->relationItemField('unit'),
            'reviews' => $this->paginatedRelationListField('review', 'is_accept'),
            'questions' => $this->paginatedRelationListField('question_and_answer', 'is_accept'),
            'accessories' => $this->paginatedRelationListField('product'),
            'audits' => $this->audits('product'),
            'is_active' => $this->acceptableField('product')
        ];
    }
}