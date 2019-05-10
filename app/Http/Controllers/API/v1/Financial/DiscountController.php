<?php

namespace App\Http\Controllers\API\v1\Financial;

use Illuminate\Http\Request;
use App\Models\Discount\Discount;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\Discount as DiscountResource;
use App\Http\Requests\v1\Order\DiscountRequest;
use App\ModelFilters\Financial\DiscountFilter;
use App\Helpers\HasUser;
use App\Models\Product\Variation;
use App\Http\Requests\v1\Order\DiscountItemRequest;
use App\Http\Resources\Financial\DiscountCollection;

class DiscountController extends MainController
{
    use HasUser;

    /**
     * Instantiate a new OrderController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [
                'index', 'show', 'store', 'update', 'destroy', 'add', 'remove'
            ]
        ]);
    }

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'discount';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Discount::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'discounts';

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'categories:id,title'
    ];
    
    protected $more_relations = [
        'items',
        'items.variation:id,product_id,color_id,size_id,warranty_id,inventory,sending_time',
        'items.variation.product:id,name,code,note,photos,label',
        'items.variation.color:id,name,code',
        'items.variation.size:id,name',
        'items.variation.warranty:id,title,description,logo,expire',
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = DiscountResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = DiscountCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = DiscountFilter::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new discount in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(DiscountRequest $request)
    {
        return $this->storeWithRequest( $this->changeReuqestDatetimes( $request ) );
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $discount in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        return $this->updateWithRequest( $this->changeReuqestDatetimes( $request ), $discount );
    }

    public function changeReuqestDatetimes($request)
    {
        return $request->merge([
            'started_at' => (String) \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d H:i:s', $request->started_at ),
            'expired_at' => (String) \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y-m-d H:i:s', $request->expired_at )
        ]);
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $discount
     * @return void
     */
    public function afterCreate($request, $discount)
    {
        $discount->categories()->attach( $request->categories );
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $discount
     * @return void
     */
    public function afterUpdate($request, $discount)
    {
        $discount->categories()->sync( $request->categories );
    }
    
    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        $this->checkPermission('read-discount');

        return $this->model::filter( request()->all(), $this->filter )
            ->with( $this->relations )
            ->paginate( $this->getPerPage() );
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getSingleData($data)
    {
        $this->checkPermission('read-discount');

        $this->relations = array_merge( $this->relations, $this->more_relations );

        return $this->model::with( $this->relations )->findOrFail($data);
    }

    /**
     * Add a variation to discount
     *
     * @param Request $request
     * @param Discount $discount
     * @param Variation $variation
     * @return void
     */
    public function add(DiscountItemRequest $request, Discount $discount, Variation $variation)
    {
        $this->checkPermission("add-item-discount");
        
        $discount->items()->updateOrCreate([
            'variation_id' => $variation->id,
        ], [
            'offer'     => $request->offer,
            'quantity'  => $request->quantity,
        ]);
        
        return response()->json([
            'message' => __('messages.discount.item.add.success', [
                'product' => $variation->product->name,
                'discount' => $discount->title
            ])
        ]);
    }

    /**
     * Remove a variation from the discount
     *
     * @param Discount $discount
     * @param Variation $variation
     * @return void
     */
    public function remove(Discount $discount, Variation $variation)
    {
        $this->checkPermission("remove-item-discount");

        if ( $variation->discount_item()->where('discount_id', $discount->id)->delete() )
        {
            return response()->json([
                'message' => __('messages.discount.item.remove.success', [
                    'product' => $variation->product->name,
                    'order' => $discount->title
                ])
            ]);
        }
        else
        {
            return response()->json([
                'message' => __('messages.discount.item.remove.failed', [
                    'order' => $discount->title
                ])
            ], 400);
        }
    }
}
