<?php

namespace App\GraphQL\Mutation\User\Cart;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Variation;
use Cookie;

class RemoveCartMutation extends BaseCartMutation
{
    /**
     * Remove a variation from the order
     *
     * @param Variation $variation
     * @return void
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $variation = Variation::findOrFail( $args['variation'] );


        if ( auth()->check() )
            $status = $this->removeCartAuth($variation);
        
        else
            $status = $this->removeCartPublic($variation);


        return [
            'status' => $status ? 200 : 400,
            'message' => $status
                ? $variation->product->name.' با موفقیت از سبد خرید شما حذف شد .'
                : 'متاسفانه هیچ محصولی از سبد خرید شما حذف نشد'
        ];
    }

    public function removeCartPublic($variation)
    {
        $cart = json_decode(Cookie::get('cart'), true);

        if ( isset( $cart[ $variation->id ] ) )
        {
            unset( $cart[ $variation->id ] );

            setcookie('cart', json_encode($cart), time() + 86400 * 30);

            return true;
        }

        return false;
    }

    public function removeCartAuth($variation)
    {
        $order = auth()->user()->orders()->where('order_status_id', 1)->firstOrFail();

        if ( $variation->order_item()->where('order_id', $order->id)->delete() )
            return true;

        return false;
    }
}