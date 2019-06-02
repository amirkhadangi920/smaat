<?php

namespace App\GraphQL\Mutation\Financial\Order;

use App\GraphQL\Helpers\DeleteMutation;
use App\Models\Financial\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Financial\OrderStatus;

class StatusOrderMutation extends BaseOrderMutation
{
    use DeleteMutation;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return true;
        return $this->checkPermission("change-order-status");
    }

    public function args()
    {
        return [
            'id'    => [
                'type' => $this->incrementing ? Type::int() : Type::string()
            ],
            'ids'    => [
                'type' => Type::listOf( $this->incrementing ? Type::int() : Type::string() )
            ],
            'status' => [
                'type' => Type::nonNull( Type::int() )
            ]
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $order = Order::findOrFail( $args['id'] ?? $args['ids'] ?? false );
        $status = OrderStatus::findOrFail( $args['status'] );

        if ( $order->order_status_id === $status->id )
        {
            return [
                'status' => 400,
                'message' => 'لطفا یک وضعیت جدید برای فاکتور انتخاب کنید'
            ];
        }

        $order->update(['order_status_id' => $status->id]);
        $order->status_changes()->attach($status->id);

        return [
            'status' => 200,
            'message' => 'وضعییت فاکتور '.$order->id.'# با موفقیت تغییر کرد .'
        ];
    }
}