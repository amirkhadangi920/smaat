<?php

namespace App\GraphQL\Query\User\Cart;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Query\MainQuery;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Financial\OrderItem;
use Cookie;
use App\Models\Product\Variation;

class CartQuery extends MainQuery
{
    public function type()
    {
        return Type::listOf( \GraphQL::type('me_order_item') );
    }

    public function args()
    {
        return [
            // 
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if ( auth()->check() )
            return $this->authCart($fields);
        
        else
            return $this->publicCart();
    }

    public function publicCart()
    {
        $result = [];
        
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $items = Variation::find( array_keys( $cart ) );

        foreach ( $items as $item )
        {
            $result[] = [
                'id' => $item->id,
                'count' => $cart[ $item->id ],
                'variation' => $item
            ];
        }
        
        return $result;
    }

    public function authCart($fields)
    {
        return OrderItem::where('order_id', $this->getCart()->id)
            ->whereHas('variation', function($query) {
                return $query->where('is_active', 1);
            })
            ->whereHas('variation.product', function($query) {
                return $query->where('is_active', 1);
            })
            ->with( $fields->getRelations() )
            ->select( $this->getSelectFields($fields) )
            ->get();
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
}