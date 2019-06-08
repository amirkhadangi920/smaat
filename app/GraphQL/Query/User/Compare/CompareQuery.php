<?php

namespace App\GraphQL\Query\User\Compare;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Query\MainQuery;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use Cookie;
use App\Models\Spec\Spec;
use App\Models\Product\Product;

class CompareQuery extends MainQuery
{
    public function type()
    {
        return \GraphQL::type('spec');
    }

    public function args()
    {
        return [
            // 
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if ( !Cookie::get('compare_table') || !Cookie::get('compare_products') )
            die(json_encode([ 'status' => false  ]));
            
        $products = json_decode( \Cookie::get('compare_products', '[]') );
            
        if ( Product::find($products)->count() !== count($products) )
        {
            setcookie('compare_products', '[]', time() - 1);
            die(json_encode([ 'status' => false  ]));
        }

        return Spec::whereId( Cookie::get('compare_table') )
            ->with( $fields->getRelations() )
            ->select( $this->getSelectFields($fields) )
            ->first();
    }
}