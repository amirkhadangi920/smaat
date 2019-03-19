<?php

namespace App\Http\Controllers\API\v1;

use Cookie;
use Validator;
use App\Models\Product\Variation;
use App\Models\Financial\Order;
use App\Http\Resources\Financial\Order as OrderResource;
use Illuminate\Http\Request;
use App\Http\Requests\v1\Order\PaymentRequest;
use Gateway;
class CartController extends MainController
{

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
        'promocode:id,code,value,min_total,max,quantity,reward_type,expired_at',
        'shipping_method:id,name,description,logo,cost,minimum',
        'items',
        'items.variation:id,product_id,color_id,size_id,warranty_id,sales_price,inventory,sending_time',
        'items.variation.product:id,category_id,slug,name,code,note,photos,label',
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
     * Instantiate a new CartController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'index', 'add', 'remove', 'check', 'payment' ]
        ]);
    }

    /**
     * Get all the shopping cart items
     *
     * @return void
     */
    public function index()
    {
        $order = $this->getCart()->load( $this->more_relations );

        return (new $this->resource( $order ))->additional([
            'message' => 'سبد خرید شما'
        ]);
    }

    /**
     * Validate the product status & it's inventory
     * for adding to shopping cart
     *
     * @param Variation $variation
     * @param integer $quantity
     * @return void
     */
    public function validateForAdd($variation, $quantity)
    {
        Validator::make([
            'quantity'  => $quantity,
            'label'     => $variation->product->label,
            'inventory' => $variation->inventory
        ], [
            'quantity'  => 'required|integer|min:1',
            'label'     => 'in:',
            'inventory' => "nullable|integer|min:{$quantity}"
        ], [
            'label.in'  => 'متاسفانه امکان ثبت این محصول در حال حاضر ممکن نیست .',
            'inventory.max' => 'متاسفانه در حاضر موجودی انبار این محصول حداکثر '.$variation->inventory.' عدد است '
        ])->validate();
    }

    /**
     * Find the unpaid order of the current user
     * or create new one for him
     *
     * @return void
     */
    public function getCart()
    {
        return auth()->user()->orders()->firstOrCreate([
            'order_status_id'   => 1
        ], [
            'city_id'           => auth()->user()->city_id,
            'destination'       => auth()->user()->address,
            'postal_code'       => auth()->user()->postal_code
        ]);
    }

    /**
     * Add a variation to shopping cart
     *
     * @param Variation $variation
     * @return void
     */
    public function add(Variation $variation, int $quantity = 1)
    {
        $this->validateForAdd($variation, $quantity);
        
        $order = $this->getCart();
        
        $order->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'count'        => $quantity,
            'price'        => $variation->sales_price,
            // 'offer'        => ( $variation->offer && $variation->offer < $variation->price )
            //                         ? $variation->price - $variation->offer : 0
        ]);
        
        return (new $this->resource( $order->load('items') ))->additional([
            'message' => $variation->product->name.' با موفقیت به سبد خرید شما اضافه شد .'
        ]);
    }

    /**
     * Remove a variation from the order
     *
     * @param Variation $variation
     * @return void
     */
    public function remove(Variation $variation)
    {
        $order = auth()->user()->orders()->where('order_status_id', 1)->firstOrFail();

        if ( $variation->order_item()->where('order_id', $order->id)->delete() )
        {
            return response()->json([
                'message' => $variation->product->name.' با موفقیت از سبد خرید شما حذف شد .'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'متاسفانه هیچ محصولی از سبد خرید شما حذف نشد'
            ], 400);
        }
    }

    /**
     * Check the product label & stock inventory for cart items
     * also calcuate order total and offer
     *
     * @param boolean $response
     * @return void
     */
    public function check(bool $response = true)
    {
        $order = $this->getCart()->load( array_merge($this->more_relations, [
            'items.variation.product.category',
            'items.variation.discount_item',
            'items.variation.discount_item.discount',
        ]));
        
        $order->items->each( function ( $item ) 
        { 
            $item->priceAndOffer()
                 ->checkInventory()
                 ->save();

            $item->checkLabel();
            $item->checkQuantity();
        });

        $order->canUsePromocode()
              ->calculatePromocodeOffer()
              ->calculateShippingCost()
              ->save();


        if ( !$response )
            return $order;

        return (new $this->resource( $order ))->additional([
            'message' => 'سبد خرید شما با موفقیت بررسی شد'
        ]);
    }

    /**
     * Record the buyer & order information
     * then connect to payment gateway
     *
     * @param Request $request
     * @param boolean $decrease
     * @return void
     */
    public function payment(PaymentRequest $request)
    {
        $order = $this->check(false);

        auth()->user()->update( array_merge(
            $request->only('city_id', 'first_name', 'last_name', 'national_code', 'postal_code'), [
                'phones' => array_merge( auth()->user()->phones ?? [], [ 'main' => $request->phone ] ),
                'address' => $request->destination
            ]
        ));

        $order->update( array_merge(
            $request->only('city_id', 'shipping_method_id', 'destination', 'postal_code'), [
                'descriptions' => array_merge($order->descriptions ?? [], [ 'buyer' => $request->description ] )
            ]
        ));

        return $this->connectToGateway( $order );
    }

    public function connectToGateway($order)
    {
        try
        {
            $gateway = Gateway::ZARINPAL();
            
            $gateway->price( $order->calculateTotal() * 10 )->ready();
         
            $order->ref_id = $gateway->refId();
            $order->trans_id = $gateway->transactionId();
            $order->save();
   
            return $gateway->redirect();
        }
        catch (\Exception $e)
        {   
            echo $e->getMessage();
        }
    }

    public function verify_payment()
    {
        try
        {
            $order = Order::first()->load( $this->more_relations );

            $order->usePromocode();


            // $gateway = Gateway::verify();
        
            // $order = Order::where('ref_id', $gateway->refId() )->first();
            // $order->tracking_code = $gateway->trackingCode();
            // $order->save();
        }
        catch (\Larabookir\Gateway\Exceptions\RetryException $e)
        {
             // تراکنش قبلا سمت بانک تاییده شده است و
             // کاربر احتمالا صفحه را مجددا رفرش کرده است
             // لذا تنها فاکتور خرید قبل را مجدد به کاربر نمایش میدهیم
             
            echo $e->getMessage() . "<br>";
             
        }
        catch (\Exception $e)
        {
            
            // نمایش خطای بانک
            echo $e->getMessage();
        }  
    }
}
