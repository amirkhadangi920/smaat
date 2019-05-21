<?php

namespace App\GraphQL\Props\Financial;

use App\Http\Resources\Financial\Order as OrderResource;
use App\Models\Financial\Order;
use App\ModelFilters\Financial\OrderFilter;
use App\Http\Requests\v1\Order\OrderRequest;
use App\Http\Resources\Financial\OrderCollection;

trait OrderProps
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
        'order_status:id,title,color,description',
    ];
    
    protected $more_relations = [
        'promocode:id,code,value,min_total,reward_type,expired_at',
        'shipping_method:id,name,description,logo,cost,minimum',
        'items',
        'items.variation:id,product_id,color_id,size_id,warranty_id,inventory,sending_time',
        'items.variation.product:id,unit_id,name,code,note,photos,label',
        'items.variation.product.unit:id,   ',
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
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = OrderCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = OrderFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = OrderRequest::class;
}