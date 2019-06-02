<?php

namespace App\GraphQL\Mutation\User\Compare;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Product;
use Cookie;

class RemoveCompareMutation extends BaseCompareMutation
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
        $compares = json_decode( Cookie::get('compare_products', '[]'), true );
        
        if ( in_array($product->id, $compares) )
        {
            $index = array_search($product->id, $compares);
            unset( $compares[$index] );

            setcookie('compare_products', json_encode( $compares ), time() + 86400 * 7);
            
            return [
                'status' => 400,
                'message' => $product->name.'با موفقیت از مقایسه حذف شد .'
            ];
        } 
        
        return [
            'status' => 200,
            'message' => $product->name.'در مقایسه موجود نیست .'
        ];
    }
}