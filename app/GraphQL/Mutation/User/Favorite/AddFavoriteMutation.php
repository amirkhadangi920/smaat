<?php

namespace App\GraphQL\Mutation\User\Favorite;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Product;

class AddFavoriteMutation extends BaseFavoriteMutation
{  
    /**
     * Add a variation to shopping cart
     *
     * @param Variation $variation
     * @return void
     */
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $product = Product::findOrFail( $args['product'] );

        auth()->user()->favorites()->syncWithoutDetaching( $product->id );

        return [
            'status' => 200,
            'message' => $product->name.'با موفقیت به لیست علاقه مندی ها اضافه شد .'
        ];
    }
}