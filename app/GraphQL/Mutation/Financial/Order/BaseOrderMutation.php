<?php

namespace App\GraphQL\Mutation\Financial\Order;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Financial\OrderProps;

class BaseOrderMutation extends MainMutation
{
    use OrderProps;
    
    protected $incrementing = false;
    
    protected $attributes = [
        'name' => 'OrderMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            // 'name' => [
            //     'type' => Type::string()
            // ],
            // 'description' => [
            //     'type' => Type::string()
            // ],
            // 'cost' => [
            //     'type' => Type::int()
            // ],
            // 'logo' => [
            //     'type' => UploadType::getInstance()
            // ],
            // 'minimum' => [
            //     'type' => Type::int()
            // ],
            // 'is_active' => [
            //     'type' => Type::boolean()
            // ]
        ];
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function createNewModel($data)
    {
        return User::findOrFail( request('user_id') )->orders()->create( $data );
    }

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest($request, $order = null)
    {
        $request->put('descriptions', $this->getDescriptions($order));
        
        $request->put('datetimes', [
            'status' => 1,
            'time' => time()
        ]);

        $request->put('order_status_id', 1);
        
        return $request->only(
            'city_id', 'descriptions', 'destination', 'postal_code',
            'shipping_method_id', 'docs', 'datetimes', 'order_status_id'
        )->all();
    }

    /**
     * Check the request to it'has image or not,
     * then create a data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function storeData($request)
    {
        return $this->createNewModel(
            $this->getRequest(
                $this->requestWithGallery( $request, 'docs' )
            )
        );
    }

    /**
     * Check the request to it'has image or not,
     * then update the data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function updateData($request, $order)
    {
        $order->update(
            $this->getRequest(
                $this->requestWithGallery( $request, 'docs', $order ), $order
            )
        );
    }

    /**
     * Add a description for an order
     *
     * @param Order $order
     * @return JSON/Array
     */
    public function description (Order $order)
    {
        $this->checkPermission("add-order-description");

        Validator::make([ 'description' => request('description') ], [
            'description' => 'required|max:255|string',
        ])->validate();

        $description = $this->getDescriptions($order);

        $order->update([ 'descriptions' => $description ]);

        return response()->json([
            'data'      => $order->descriptions,
            'message'   => 'توضیح شما برای فاکتور '.$order->id.'# با موفقیت ثبت شد .'
        ]);
    }

    /**
     * Change the order status
     *
     * @param Order $order
     * @param integer $status
     * @return JSON\Array
     */
    public function status(Order $order, OrderStatus $status)
    {
        $this->checkPermission("change-order-status");

        $datetimes = collect( $order->datetimes ? $order->datetimes : [] );

        if ( $datetimes->last()['status'] === $status->id )
        {
            return response()->json([
                'message' => 'لطفا یک وضعیت جدید برای فاکتور انتخاب کنید'
            ], 400);
        }

        $order->update([
            'datetimes' => $datetimes->push([
                'status' => $status->id,
                'time' => time()
            ]),
            'order_status_id' => $status->id
        ]);

        return response()->json([
            'data' => $datetimes,
            'message' => 'وضعییت فاکتور '.$order->id.'# با موفقیت تغییر کرد .'
        ]);
    }

    /**
     * Get the array of descriptions & add a new for the order
     *
     * @param Order $order
     * @return void
     */
    public function getDescriptions(Order $order = null)
    {
        if ( $order->descriptions ?? false )
        {
            return array_merge( $order->descriptions, [
                auth()->user()->id => request('description')
            ]);
        } else {
            return [
                auth()->user()->id => request('description')
            ];
        }
    }
}