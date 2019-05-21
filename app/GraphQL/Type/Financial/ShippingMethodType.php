<?php

namespace App\GraphQL\Type\Financial;

use App\GraphQL\Type\BaseType;
use GraphQL\Type\Definition\Type;
use App\Models\Financial\ShippingMethod;

class ShippingMethodType extends BaseType
{
    protected $attributes = [
        'name' => 'ShippingMethodType',
        'description' => 'A type',
        'model' => ShippingMethod::class
    ];

    public function get_fields()
    {
        return $this->infoField('name') + [
            'is_mine' => $this->isMineField(),
            'creator' => $this->creator('shipping_method'),
            'logo' => $this->imageField(),
            'cost' => [
                'type' => Type::int()
            ],
            'minimum' => [
                'type' => Type::int()
            ],
            'audits' => $this->audits('shipping_method'),
            'is_active' => $this->acceptableField('shipping_method'),
        ];
    }
}