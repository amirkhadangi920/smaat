<?php

namespace App\GraphQL\Mutation\Financial\Discount;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\UploadType;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\DiscountProps;

class BaseDiscountMutation extends MainMutation
{
    use DiscountProps;
    
    protected $attributes = [
        'name' => 'DiscountMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'title' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'logo' => [
                'type' => UploadType::getInstance()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'is_active' => [
                'type' => Type::boolean()
            ],
            'started_at' => [
                'type' => Type::string()
            ],
            'expired_at' => [
                'type' => Type::string()
            ],
        ];
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $discount
     * @return void
     */
    public function afterCreate($request, $discount)
    {
        $discount->categories()->attach( $request->get('categories') );
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $discount
     * @return void
     */
    public function afterUpdate($request, $discount)
    {
        $discount->categories()->sync( $request->get('categories') );
    }
}