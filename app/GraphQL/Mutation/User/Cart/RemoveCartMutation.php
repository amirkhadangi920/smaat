<?php

namespace App\GraphQL\Mutation\User\Cart;

use App\GraphQL\Mutation\MainMutation;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Variation;

class RemoveCartMutation extends MainMutation
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

        $order = auth()->user()->orders()->where('order_status_id', 1)->firstOrFail();

        if ( $variation->order_item()->where('order_id', $order->id)->delete() )
        {
            return [
                'status' => 200,
                'message' => $variation->product->name.' با موفقیت از سبد خرید شما حذف شد .'
            ];
        }
        
        return [
            'status' => 400,
            'message' => 'متاسفانه هیچ محصولی از سبد خرید شما حذف نشد'
        ];
    }
}