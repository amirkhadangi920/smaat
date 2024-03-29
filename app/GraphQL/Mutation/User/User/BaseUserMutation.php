<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\UserProps;
use Rebing\GraphQL\Support\UploadType;
use Cookie;
use App\Models\Product\Variation;

class BaseUserMutation extends MainMutation
{
    use UserProps;
    
    protected $incrementing = false;
    
    protected $attributes = [
        'name' => 'UserMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'city_id' => [
                'type' => Type::int()
            ],
            'first_name' => [
                'type' => Type::string()
            ],
            'last_name' => [
                'type' => Type::string()
            ],
            'phones' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'social_links' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'email' => [
                'type' => Type::string()
            ],
            'password' => [
                'type' => Type::string()
            ],
            'password_confirmation' => [
                'type' => Type::string()
            ],
            'avatar' => [
                'type' => UploadType::getInstance()
            ],
            'national_code' => [
                'type' => Type::string()
            ],
            'gender' => [
                'type' => Type::boolean()
            ],
            'roles' => [
                'type' => Type::listOf( Type::int() )
            ],
            'is_deleted_image' => [
                'type' => Type::boolean()
            ],
            'permissions' => [
                'type' => Type::listOf( Type::int() )
            ],
            // 'is_active' => [
            //     'type' => Type::boolean()
            // ]
        ];
    }
    
    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $user)
    {
        if ( auth()->id() !== $request->get('id') )
        {
            $user->syncPermissions( $request->get('permissions', []) );
            $user->syncRoles( $request->get('roles', [])  );
        }
    }
    
    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        return $request->only(
            'first_name',
            'last_name',
            'email',
            'avatar',
            'national_code',
            'gender'
        )->all();
    }

    /**
     * Find the unpaid order of the current user
     * or create new one for him
     *
     * @return void
     */
    public function getCart()
    {
        return auth()->user()->orders()->firstOrCreate([
            'order_status_id'   => 1
        ], [
            'city_id'           => auth()->user()->city_id,
            'destination'       => auth()->user()->address,
            'postal_code'       => auth()->user()->postal_code
        ]);
    }


    public function moveLocalCartToServer()
    {
        $local_cart = $this->getLocalCart();

        if ( count($local_cart) === 0 )
            return;

            
        $order = $this->getCart();

        foreach ( $local_cart as $item )
        {
            $order->items()->updateOrCreate([
                'variation_id' => $item['variation']['id'],
            ], [
                'count'        => $item['count']
            ]);
        }
        
        setcookie('cart', '[]', time() + 86400 * 30);
    }

    public function getLocalCart()
    {
        $result = [];
        
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $items = Variation::select('id')->find( array_keys( $cart ) );

        foreach ( $items as $item )
        {
            if ( !$item ) continue;

            $result[] = [
                'id' => $item->id,
                'count' => $cart[ $item->id ],
                'variation' => $item
            ];
        }
        
        return $result;
    }
}