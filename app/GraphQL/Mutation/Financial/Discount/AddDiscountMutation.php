<?php

namespace App\GraphQL\Mutation\Financial\Discount;

use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use App\Http\Requests\v1\Order\DiscountItemRequest;
use GraphQL\Type\Definition\Type;
use App\Models\Discount\Discount;
use App\Models\Product\Variation;

class AddDiscountMutation extends BaseDiscountMutation
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
        return $this->checkPermission("add-item-discount");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(array $args = [])
    {
        return ( new DiscountItemRequest )->rules($args);
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
            'offer' => [
                'type' => Type::int()
            ],
            'quantity' => [
                'type' => Type::int()
            ],
        ];
    }
   
    
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $discount = Discount::findOrFail( $args['discount'] );
        $variation = Variation::findOrFail( $args['variation'] );

        $discount->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'offer'     => $args['offer'],
            'quantity'  => $args['quantity'] ?? 1,
        ]);
        
        return [
            'status' => 200,
            'message' => __('messages.discount.item.add.success', [
                'product' => $variation->product->name,
                'discount' => $discount->title
            ])
        ];
    }
}