<?php

namespace App\GraphQL\Type\Spec;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Spec\Spec;

class SpecType extends BaseType
{
    protected $attributes = [
        'name' => 'SpecType',
        'description' => 'A type',
        'model' => Spec::class
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
            'category' => $this->relationItemField('category'),
            'headers' => $this->relationListField('spec_header', 'is_active', 'read-specification'),
            'filters' => [
                'type'  => Type::listOf( \GraphQL::type('spec_row') ),
                'query' => function(array $args, $query) {
                
                    if ( !$this->checkPermission('read-specification') )
                        $query->where('spec_row.is_active', 1);
            
                    $query->whereHas('defaults');
                    $query->where('is_filterable', true);

                    return $query;
                }
            ],
            'audits' => $this->audits('specification'),
            'is_active' => $this->acceptableField('specification')
        ];
    }
}