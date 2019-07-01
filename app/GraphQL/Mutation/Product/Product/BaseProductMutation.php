<?php

namespace App\GraphQL\Mutation\Product\Product;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Product\ProductProps;
use Rebing\GraphQL\Support\UploadType;
use App\Models\Spec\SpecData;
use App\Models\Spec\SpecRow;
use Spatie\MediaLibrary\Models\Media;
use App\GraphQL\Input\ReviewInput;

class BaseProductMutation extends MainMutation
{
    use ProductProps;
    
    protected $incrementing = false;

    protected $old_spec;
    
    protected $attributes = [
        'name' => 'ProductMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'specs' => [
                'type' => Type::listOf( \GraphQL::type('spec_input') )
            ],
            'brand_id' => [
                'type' => Type::int()
            ],
            'label_id' => [
                'type' => Type::int()
            ],
            'unit_id' => [
                'type' => Type::int()
            ],
            'spec_id' => [
                'type' => Type::int()
            ],
            'categories' => [
                'type' => Type::listOf( Type::int() )
            ],
            'colors' => [
                'type' => Type::listOf( Type::int() )
            ],
            'parent_id' => [
                'type' => Type::int()
            ],
            'name' => [
                'type' => Type::string()
            ],
            'second_name' => [
                'type' => Type::listOf( Type::string() )
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
            'short_review' => [
                'type' => Type::string()
            ],
            'expert_review' => [
                'type' => Type::string()
            ],
            'tags' => [
                'type' => Type::listOf( Type::string() )
            ],
            'advantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'disadvantages' => [
                'type' => Type::listOf( Type::string() )
            ],
            'photos' => [
                'type' => Type::listOf( \GraphQL::type('image_color_input') )
            ],
            'accessories' => [
                'type' => Type::listOf( Type::string() )
            ],
            'deleted_images' => [
                'type' => Type::listOf( Type::int() )
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
        $product = $this->createNewModel( $this->getRequest( $request ) );

        if ( $request->get('photos') )
        {
            foreach ( $request->get('photos') as $item )
            {
                $product->addMedia( $item['image'] )
                    ->withCustomProperties(['color' => $item['color']])
                    ->toMediaCollection('photos');
            }
        }

        return $product;
    }

    /**
     * Check the request to it'has image or not,
     * then update the data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function updateData($request, $product)
    {
        $this->old_spec = $product->spec_id;

        $product->update( $this->getRequest( $request ) );

        if ( $request->get('photos') )
        {
            foreach ( $request->get('photos') as $item )
            {
                $product->addMedia( $item['image'] )
                    ->withCustomProperties(['color' => $item['color']])
                    ->toMediaCollection('photos');
            }
        }

        if ( $request->get('deleted_images') )
            Media::whereIn('id', $request->get('deleted_images'))->delete();

        return $product;
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
        $product->accessories()->attach( $request->get('accessories') );
        $product->categories()->attach( $request->get('categories') );
        $product->colors()->attach( $request->get('colors') );
        $product->attachTags( $request->get('tags') );
        
        
        if ( $request->get('specs', false) && count( $request->get('specs', []) ) )
            $this->createSpecData($request, $product);
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
        $product->accessories()->sync( $request->get('accessories') );
        $product->categories()->sync( $request->get('categories') );
        $product->colors()->sync( $request->get('colors') );
        $product->syncTags( $request->get('tags') );

        
        if ( $this->old_spec !== $product->spec_id )
            $product->spec_data()->delete();


        if ( $request->get('specs', false) && count( $request->get('specs', []) ) )
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
        $spec = $product->spec->load([
            'headers:id,spec_id',
            'headers.rows:id,spec_header_id',
            'headers.rows.defaults:id,spec_row_id',
            'headers.rows.data' => function($query) use($product) {
                return $query->where('product_id', $product->id);
            }
        ]);

        $rows = $spec->headers->map(function($item) {
            return $item->rows;
        })->flatten(1)->keyBy('id');


        foreach ( $request->get('specs') as $key => $item )
        {
            $row = $rows[ $item['id'] ];

            if ( $row->defaults()->count() !== 0 )
            {
                $values = $row->defaults;

                if ( $item['values'] ?? false )
                    $values = $values->whereIn('id', $item['values']);
                    
                elseif ( $item['value'] ?? false )
                    $values = $values->where('id', $item['value']);
                
                else
                    $values = collect([]);
                
                $this->createNewSpecData($row, $product, null, $values->pluck('id'));
            }
            else
                $this->createNewSpecData($row, $product, $item['data']);
        }
    }

    public function createNewSpecData($row, $product, $data = null, $values = [])
    {
        if ( $row->data )
        {
            $row->data->update([ 'data' => $data ]);
            $row->data->values()->sync( $values );
        }
        else
        {
            $spec_data = $row->data()->create([
                'product_id' => $product->id,
                'data' => $data
            ]);

            $spec_data->values()->sync( $values );
        }
    }
}