<?php

namespace App\GraphQL\Mutation\Spec\Spec;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Spec\SpecProps;

class BaseSpecMutation extends MainMutation
{
    use SpecProps;
    
    protected $attributes = [
        'name' => 'SpecMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $feature)
    {
        $feature->categories()->attach( $request->get('categories') );
    }
    
    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterUpdate($request, $feature)
    {
        $feature->categories()->sync( $request->get('categories') );
    }
}