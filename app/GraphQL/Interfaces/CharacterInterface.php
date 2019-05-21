<?php

namespace App\GraphQL\Interfaces;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InterfaceType;

class CharacterInterface extends InterfaceType
{
    protected $attributes = [
        'name' => 'Character',
        'description' => 'Character interface.',
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the character.'
            ],
            'is_active' => [
                'type' => Type::boolean(),
                'privacy' => function() { return auth()->check(); }
            ],
            'name' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
        ];
    }
}