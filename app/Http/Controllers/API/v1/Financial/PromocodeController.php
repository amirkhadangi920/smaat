<?php

namespace App\Http\Controllers\API\v1\Financial;

use Illuminate\Http\Request;
use App\Models\Promocode\Promocode;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Financial\Promocode as PromocodeResource;
use App\Http\Requests\v1\Order\PromocodeRequest;
use App\ModelFilters\Financial\PromocodeFilter;

class PromocodeController extends MainController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'promocode';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Promocode::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [

    ];
    
    protected $more_relations;

    public function __construct()
    {
        parent::__construct();

        $this->more_relations = [
            'categories:id,slug,title',
            'users',
            'variations:id,product_id,color_id,size_id,warranty_id,inventory,sending_time',
            'variations.product:id,slug,name,code,note,photos,label',
            'variations.color:id,name,code',
            'variations.size:id,name',
            'variations.warranty:id,title,description,logo,expire',
            'orders:id,promocode_id,user_id,total,offer,paid_at',
            'orders.user',
            'orders' => function ( $query ) {
                $query->latest()->paginate(20);
            }
        ];
    }

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = PromocodeResource::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = PromocodeFilter::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new promocode in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(PromocodeRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $promocode in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(PromocodeRequest $request, Promocode $promocode)
    {
        return $this->updateWithRequest($request, $promocode);
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $promocode
     * @return void
     */
    public function afterCreate($request, $promocode)
    {
        $promocode->categories()->attach( $request->categories );
        $promocode->variations()->attach( $request->variations );
        $promocode->users()->attach( $request->users );
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $promocode
     * @return void
     */
    public function afterUpdate($request, $promocode)
    {
        $promocode->categories()->sync( $request->categories );
        $promocode->variations()->sync( $request->variations );
        $promocode->users()->sync( $request->users );
    }
}
