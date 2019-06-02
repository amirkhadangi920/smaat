<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Financial\OrderStatus;

class OrderStatusType extends BaseType
{
    protected $attributes = [
        'name' => 'OrderStatusType',
        'description' => 'A type',
        'model' => OrderStatus::class
    ];

    public function get_fields()
    {
        return [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('order_status'),
            'title' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'description' => [
                'type' => Type::string(),
                'selectable' => false
            ],
            'color' => [
                'type' => Type::string()
            ],
            'changed_at' => [
                'type' => Type::string(),
                'resolve' => function($data) {
                    return $data->pivot->changed_at ?? null;
                },
                'selectable' => false
            ],
            'audits' => $this->audits('order_status'),
            'is_active' => $this->acceptableField('order_status')
        ];
    }
}