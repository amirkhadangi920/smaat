<?php

namespace App\GraphQL\Mutation\User\Cart;

use App\GraphQL\Mutation\MainMutation;
use App\Models\Product\Variation;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class AddCartMutation extends MainMutation
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
        
        $order = $this->getCart();
        
        $order->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'count'        => $quantity,
            'price'        => $variation->sales_price,
        ]);
        
        return [
            'status' => 200,
            'message' => $variation->product->name.' با موفقیت به سبد خرید شما اضافه شد .'
        ];
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
            'label'     => $variation->product->label,
            'inventory' => $variation->inventory
        ], [
            'quantity'  => 'required|integer|min:1',
            'label'     => 'in:',
            'inventory' => "nullable|integer|min:{$quantity}"
        ], [
            'label.in'  => 'متاسفانه امکان ثبت این محصول در حال حاضر ممکن نیست .',
            'inventory.max' => 'متاسفانه در حاضر موجودی انبار این محصول حداکثر '.$variation->inventory.' عدد است '
        ])->validate();
    }
}