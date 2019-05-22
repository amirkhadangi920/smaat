<?php

namespace App\GraphQL\Mutation\Product\Product;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Product\ProductProps;
use Rebing\GraphQL\Support\UploadType;
use App\Models\Spec\SpecData;
use App\Models\Spec\SpecRow;

class BaseProductMutation extends MainMutation
{
    use ProductProps;
    
    protected $incrementing = false;
    
    protected $attributes = [
        'name' => 'ProductMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'brand_id' => [
                'type' => Type::int()
            ],
            'category_id' => [
                'type' => Type::int()
            ],
            'unit_id' => [
                'type' => Type::int()
            ],
            'spec_id' => [
                'type' => Type::int()
            ],
            'parent_id' => [
                'type' => Type::int()
            ],
            'name' => [
                'type' => Type::string()
            ],
            'second_name' => [
                'type' => Type::string()
            ],
            'code' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'aparat_video' => [
                'type' => Type::string()
            ],
            'review' => [
                'type' => Type::string()
            ],
            'advantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'product' => [
                'type' => UploadType::getInstance()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
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
        $product->variations()->createMany( $request->get('variations') );
        $product->accessories()->attach( $request->get('accessories') );
        $product->attachTags( $request->get('keywords') );
        
        if ( $spec_id = $product->category->spec->id ?? null )
            $product->update([ 'spec_id' => $spec_id ]);
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
        $product->variations()->createMany( $request->get('variations') );
        $product->accessories()->sync( $request->get('accessories') );
        $product->syncTags( $request->get('keywords') );

        if ( !$product->spec_id && $spec_id = $product->category->spec->id ?? null )
            $product->update([ 'spec_id' => $spec_id ]);

        $this->createSpecData($request, $product);
    }

    /**
     * Create records for specification data for specific product
     *
     * @param Request $request
     * @param id $product
     * @return void
     */
    public function createSpecData($request, $product)
    {
        SpecData::where('product_id', $product->id)->delete();
        
        if ( $request->specs )
        {
            foreach ( $request->get('specs') as $key => $item )
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