<?php

namespace App\GraphQL\Mutation\User\Cart;

use App\GraphQL\Mutation\MainMutation;
use App\Models\Product\Variation;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class AddCartMutation extends BaseCartMutation
{  
    /**
     * Add a variation to shopping cart
     *
     * @param Variation $variation
     * @return void
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $this->validateForAdd(
            $variation = Variation::findOrFail($args['variation']),
            $quantity = $args['quantity'] ?? 1
        );

        if ( auth()->check() )
            $this->addCartAuth($variation, $quantity);
        
        else
            $this->addCartPublic($variation, $quantity);
        
        return [
            'status' => 200,
            'message' => $variation->product->name.' با موفقیت به سبد خرید شما اضافه شد .'
        ];
    }

    public function addCartAuth($variation, $quantity = 1)
    {
        $order = $this->getCart();
        
        $order->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'count'        => $quantity,
        ]);
    }
    
    public function addCartPublic($variation, $quantity = 1)
    {
        $cart = json_decode(Cookie::get('cart'), true);

        $cart[ $variation->id ] = $quantity;

        setcookie('cart', json_encode($cart), time() + 86400 * 30);
    }

    /**
     * Validate the product status & it's inventory
     * for adding to shopping cart
     *
     * @param Variation $variation
     * @param integer $quantity
     * @return void
     */
    public function validateForAdd($variation, $quantity)
    {
        Validator::make([
            'quantity'  => $quantity,
            'inventory' => $variation->inventory
        ], [
            'quantity'  => 'required|integer|min:1',
            'inventory' => "nullable|integer|min:{$quantity}"
        ], [
            'inventory.max' => "متاسفانه در حاضر موجودی انبار این محصول کمتر از {$quantity} عدد است "
        ])->validate();
    }
}