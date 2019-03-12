<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Product\Variation;
use Cookie;
use Validator;

class CartController extends Controller
{
    /**
     * Add a variation to shopping cart
     *
     * @param Variation $variation
     * @return void
     */
    public function add(Variation $variation, int $quantity = 1)
    {
        // Validate input data and product status , stock_inventory
        $values = Validator::make([
                'quantity'  => $quantity,
                'label'     => $variation->product->label,
                'inventory' => $variation->inventory
            ], [
                'quantity'  => 'required|min:1|integer',
                'label'     => 'not_in:1,2,3,4',
                'inventory' => "integer|min:{$quantity}"
            ], [
                'label.not_in'  => 'متاسفانه امکان ثبت این محصول در حال حاضر ممکن نیست .',
                'inventory.max' => 'متاسفانه در حاضر موجودی انبار این محصول حداکثر '.$variation->inventory.' عدد است '
        ])->validate();
        
        // Check if the user has logged in , create order for his/him and assign variation to that
        if ( auth()->check() )
        {
            $order = auth()->user()->orders()->firstOrCreate([
                'order_status_id' => 1,
            ], [
                'destination' => auth()->user()->address,
                'postal_code' => auth()->user()->postal_code,
                'city_id' => auth()->user()->city_id,
            ]);

            $order->items()->updateOrCreate([
                'variation_id' => $variation->id,
            ], [
                'count'        => $quantity,
                'price'        => $variation->sales_price,
                // 'offer'        => ( $variation->offer && $variation->offer < $variation->price )
                //                         ? $variation->price - $variation->offer : 0
            ]);
            
            return (new $this->resource( $order->load('items') ))->additional([
                'message' => $variation->product->name.' با موفقیت به سبد خرید شما اضافه شد .'
            ]);
        }

        // If the use doesn't logged in , save it's order item in cookies
        $cart =  json_decode(Cookie::get('cart'), true);
        $cart[ $variation->id ] = $quantity;
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);

        return response()->json([
            'data' => $cart,
            'message' => $variation->product->name.' با موفقیت به سبد خرید شما اضافه شد .'
        ]);
    }

    /**
     * Remove a variation from the order
     *
     * @param Variation $variation
     * @return void
     */
    public function remove(Variation $variation)
    {
        // Check if user has logged in , remove a variation from order_items table in DB
        if ( auth()->check() )
        {
            $order = auth()->user()->orders()->where('order_status_id', 1)->firstOrFail();
            
            if ( $variation->order_item()->where('order_id', $order->id)->delete() )
            {
                return response()->json([
                    'message' => $variation->product->name.' با موفقیت از سبد خرید شما حذف شد .'
                ]);
            }
            else
            {
                return response()->json([
                    'message' => 'متاسفانه هیچ محصولی از سبد خرید شما حذف نشد'
                ], 400);
            }
            
        }
        // Check if user doesn't logged in , remove a variation from the Cookies
        elseif ( $cart =  json_decode(Cookie::get('cart'), true) ) 
        {
            unset( $cart[ $variation->id ] );
            Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);
            
            return response()->json([
                'message', $variation->product->name.' با موفقیت از سبد خرید شما حذف شد .'
            ]);
        }

        return response()->json(null, 400);
    }
}
