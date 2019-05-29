<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\SpecRow;

class SpecRowType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecRowType',
        'description' => 'A type',
        'model' => SpecRow::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('specification'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'prefix' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'postfix' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'defaults' => [
                'type' => Type::listOf( \GraphQL::type('spec_default') ),
            ],
            'data' => [
                'type' => \GraphQL::type('spec_data'),
                'query' => function($args, $query) {
                    return $query->where('product_id', $args['id'] ?? false);
                },
            ],
            'help' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'is_detailable' => [
                'type' => Type::boolean()
            ],
            'is_filterable' => [
                'type' => Type::boolean()
            ],
            'is_multiple' => [
                'type' => Type::boolean()
            ],
            'is_required' => [
                'type' => Type::boolean()
            ],
            'is_active' => $this->acceptableField('specification'),
            'audits' => $this->audits('specification'),
        ];
    }
}