<?php

namespace App\GraphQL\Query\User\Favorite;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Query\MainQuery;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Financial\OrderItem;
use Cookie;
use App\Models\Product\Variation;

class FavoriteQuery extends MainQuery
{
    public function type()
    {
        return Type::listOf( \GraphQL::type('product') );
    }

    public function args()
    {
        return [
            // 
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return auth()->user()->favorites()
            ->where('is_active', 1)
            ->whereHas('variation', function($query) {
                return $query->where('is_active', 1);
            })
            ->with( $fields->getRelations() )
            ->select( $this->getSelectFields($fields) )
            ->get();
    }
}