<?php

namespace App\GraphQL\Mutation\User\Favorite;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Product;

class RemoveFavoriteMutation extends BaseFavoriteMutation
{
    /**
     * Remove a variation from the order
     *
     * @param Variation $variation
     * @return void
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $product = Product::findOrFail( $args['product'] );

        auth()->user()->favorites()->detach( $product->id );

        return [
            'status' => 200,
            'message' => $product->name.'با موفقیت از لیست علاقه مندی ها حذف شد .'
        ];
    }
}