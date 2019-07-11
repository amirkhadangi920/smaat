<?php

namespace App\GraphQL\Mutation\Financial\Discount;

use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\Type;
use App\Models\Discount\Discount;
use App\Models\Product\Variation;

class RemoveDiscountMutation extends BaseDiscountMutation
{
    public function type()
    {
        return \GraphQL::type('result');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return $this->checkPermission("remove-item-discount");
    }

    public function args()
    {
        return [
            'discount' => [
                'type' => Type::nonNull( Type::int() )
            ],
            'variation' => [
                'type' => Type::nonNull( Type::string() )
            ],
        ];
    }
   
    
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $discount = Discount::findOrFail( $args['discount'] );
        $variation = Variation::findOrFail( $args['variation'] );

        if ( $variation->discount_item()->where('discount_id', $discount->id)->delete() )
        {
            return [
                'status' => 200,
                'message' => __('messages.discount.item.remove.success', [
                    'product' => $variation->product->name,
                    'order' => $discount->title
                ])
            ];
        }

        return [
            'status' => 400,
            'message' => __('messages.discount.item.remove.failed', [
                'order' => $discount->title
            ])
        ];
    }
}