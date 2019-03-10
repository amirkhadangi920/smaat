<?php

namespace App\Http\Controllers\API\v1\Financial;

use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\Order as OrderResource;
use App\Models\Financial\Order;
use App\Models\Product\Variation;
use Validator;
use Zend\Diactoros\Request;
use App\User;

class OrderController extends MainController
{
    /**
     * Instantiate a new OrderController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [
                'store', 'update', 'destroy', 'add', 'remove', 'description', 'status'
            ]
        ]);
    }

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'order';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Order::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'user',
        'order_status:id,title,description,cost',
    ];
    
    protected $more_relations = [
        'promocode:id,code,value,min_total,reward_type,expired_at',
        'shipping_method:id,name,description,logo,cost,minimum',
        'items',
        'items.variation:id,product_id,color_id,size_id,warranty_id,inventory,sending_time',
        'items.variation.product:id,slug,name,code,note,photos,label',
        'items.variation.color:id,name,code',
        'items.variation.size:id,name',
        'items.variation.warranty:id,title,description,logo,expire',
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = OrderResource::class;

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
     * Add a variation to shopping cart
     *
     * @param Variation $variation
     * @return void
     */
    public function add(Order $order, Variation $variation, int $quantity = 1)
    {
        $this->checkPermission("manage-order-item");

        Validator::make([
                'quantity'  => $quantity,
                'label'     => $variation->product->label,
                'inventory' => $variation->inventory
            ], [
                'quantity'  => 'required|min:1|integer',
                'label'     => 'not_in:1,2,3,4',
                'inventory' => "integer|min:{$quantity}"
            ], [
                'label.not_in'  => 'متاسفانه امکان ثبت این محصول در حال حاضر ممکن نیست .',
                'inventory.max' => 'متاسفانه در حاضر موجودی انبار این محصول حداکثر '.$variation->inventory.' عدد است '
        ])->validate();

        $order->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'count'        => $quantity,
            'price'        => $variation->sales_price,
        ]);
        
        return response()->json([
            'message' => __('messages.order.item.add.success', [
                'product' => $variation->product->name,
                '‌order' => $order->id
            ])
        ]);
    }

    /**
     * Remove a variation from the order
     *
     * @param Variation $variation
     * @return void
     */
    public function remove(Order $order, Variation $variation)
    {
        $this->checkPermission("manage-order-item");

        if ( $variation->order_item()->where('order_id', $order->id)->delete() )
        {
            return response()->json([
                'message' => __('messages.order.item.remove.success', [
                    'product' => $variation->product->name,
                    'order' => $order->id
                ])
            ]);
        }
        else
        {
            return response()->json([
                'message' => __('messages.order.item.remove.failed', [
                    'order' => $order->id
                ])
            ], 400);
        }
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
    public function status(Order $order, $status)
    {
        $this->checkPermission("change-order-status");

        Validator::make([ 'status' => $status ], [
            'status' => 'required|exists:order_statuses,id',
        ])->validate();

        $datetimes = collect( $order->datetimes ? $order->datetimes : [] );

        if ( $datetimes->last()['status'] === $status )
        {
            return response()->json([
                'message' => 'لطفا یک وضعیت جدید برای فاکتور انتخاب کنید'
            ], 400);
        }

        $order->update([
            'datetimes' => $datetimes->push([
                'status' => $status,
                'time' => time()
            ]),
            'order_status_id' => $status
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
