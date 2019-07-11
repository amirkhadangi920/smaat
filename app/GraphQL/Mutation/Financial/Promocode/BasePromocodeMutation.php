<?php

namespace App\GraphQL\Mutation\Financial\Promocode;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\PromocdeProps;

class BasePromocodeMutation extends MainMutation
{
    use PromocdeProps;
    
    protected $attributes = [
        'name' => 'PromocodeMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'code' => [
                'type' => Type::string()
            ],
            'value' => [
                'type' => Type::int()
            ],
            'min_total' => [
                'type' => Type::int()
            ],
            'max' => [
                'type' => Type::int()
            ],
            'quantity' => [
                'type' => Type::int()
            ],
            'expired_at' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'variations' => [
                'type' => Type::listOf( Type::string() )
            ],
            'users' => [
                'type' => Type::listOf( Type::string() )
            ],
        ];
    }


    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $promocode
     * @return void
     */
    public function afterCreate($request, $promocode)
    {
        $promocode->categories()->attach( $request->get('categories') );
        $promocode->variations()->attach( $request->get('variations') );
        $promocode->users()->attach( $request->get('users') );
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $promocode
     * @return void
     */
    public function afterUpdate($request, $promocode)
    {
        $promocode->categories()->sync( $request->get('categories') );
        $promocode->variations()->sync( $request->get('variations') );
        $promocode->users()->sync( $request->get('users') );
    }
}