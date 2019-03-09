<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Models\Product\Product;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\Product\Product as ProductResource;
use App\Helpers\SluggableController;
use App\Helpers\HasUser;
use App\Models\Spec\SpecRow;
use App\Models\Spec\SpecData;

class ProductController extends MainController
{
    use SluggableController, HasUser;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'product';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Product::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'category:id,slug,title',
        'brand:id,slug,name'
    ];

    protected $more_relations;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ProductResource::class;

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'products';

    public function __construct()
    {
        $this->more_relations = [
            'unit:id,title',
            'accessories:id,brand_id,slug,name,photos,label',
            'variations:id,product_id,warranty_id,color_id,size_id,purchase_price,sales_price,inventory,sending_time',
            'variations' => function ( $query ) {
                $query->whereStatus(1);
            },
            'variations.color:id,name,code',
            'variations.size:id,name',
            'variations.warranty:id,title,logo,expire',
        ];
    }

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::select(
            'id', 'user_id', 'category_id', 'brand_id', 'slug',
            'name', 'description', 'photos', 'label', 'views_count'
        )->with( $this->relations )->whereStatus(true)->latest()->paginate(20);
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getSingleData($product)
    {
        $product = $this->model::whereSlug($product)->firstOrFail();

        return $product->load( array_merge( $this->relations, $this->more_relations, [
            'spec:id',
            'spec.headers:id,spec_id,title,description',
            'spec.headers.rows:id,spec_header_id,title,label,values,help,multiple',
            'spec.headers.rows.data' => function ($query) use ($product) {
                $query->where('product_id', $product->id);
            }
        ]));
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
                $this->requestWithGallery( $request, 'photos' )
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
    public function updateData($request, $data)
    {
        $data->update(
            $this->getRequest(
                $this->requestWithGallery( $request, 'photos', $data )
            )
        );
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterCreate($request, $product)
    {
        $product->variations()->createMany( $request->variations );
        $product->accessories()->attach( $request->accessories );
        
        if ( $spec_id = $product->category->spec->id ?? null )
            $product->update([ 'spec_id' => $spec_id ]);

        $product->load( array_merge( $this->relations, $this->more_relations ));
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $product)
    {
        $product->variations()->delete();
        $product->variations()->createMany( $request->variations );
        $product->accessories()->sync( $request->accessories );

        if ( !$product->spec_id && $spec_id = $product->category->spec->id ?? null )
            $product->update([ 'spec_id' => $spec_id ]);

        $this->createSpecData($request, $product);

        $product->load( array_merge( $this->relations, $this->more_relations ));
    }

    /**
     * Create records for specification data for specific product
     *
     * @param Request $request
     * @param slug $product
     * @return void
     */
    public function createSpecData($request, $product)
    {
        SpecData::where('product_id', $product->id)->delete();
        
        if ( $request->specs )
        {
            foreach ( $request->specs as $key => $item )
            {
                if ( $item ?? false )
                {
                    SpecRow::find($key)->data()->create([
                        'product_id' => $product->id,
                        'data' => (gettype($item) == 'array') ? implode(',', $item) : $item
                    ]);
                }
            }
        }
    }
}
