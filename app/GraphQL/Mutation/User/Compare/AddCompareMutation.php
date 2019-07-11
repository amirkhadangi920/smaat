<?php

namespace App\GraphQL\Mutation\User\Compare;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Product\Product;
use Cookie;

class AddCompareMutation extends BaseCompareMutation
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
        $compares = json_decode( Cookie::get('compare_products', '[]'), true );
        
        if ( $product->spec_id != Cookie::get('compare_table')  )
        {
            setcookie('compare_table', $product->spec_id, time() + 86400 * 7);
            setcookie('compare_products', '["'.$product->id.'"]', time() + 86400 * 7);

            return [
                'status' => 200,
                'message' => $product->name.'با موفقیت به مقایسه اضافه شده است .'
            ];
        }

        if ( in_array($product->id, $compares) )
        {
            return [
                'status' => 200,
                'message' => $product->name.'قبلا به مقایسه اضافه شده است .'
            ];
        }
        
        if ( count( $compares ) > 5 )
        {
            return [
                'status' => 400,
                'message' => 'امکان افزودن بیش از پنج محصول به مقایسه مقدور نیست !'
            ];
        }
        

        setcookie('compare_products', json_encode( array_merge($compares, [ $product->id ]) ), time() + 86400 * 7);

        return [
            'status' => 200,
            'message' => $product->name.'با موفقیت به مقایسه اضافه شده است .'
        ];
    }
}