<?php

use Illuminate\Database\Seeder;

class ProductTablesSeeder extends Seeder
{
    public $products;

    public $variations;

    public function __construct()
    {
        $this->variations = collect();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $data )
    {
        $data['categories']->each( function ( $category ) use ( $data ) {

            $this->products = $category->products()->saveMany(
                factory(\App\Models\Product\Product::class, rand(1, 10))->make([
                    'user_id' => $data['users']->random()->id,
                    'brand_id' => $data['features']['brands']->random()->id,
                    'spec_id' => $data['specifications']['spec_table']
                ])
            );
        
            
            $this->products->each(function ($product) use ( $data ) {

                $this->variations = $this->variations->merge(
                    $product->variations()->saveMany(
                        factory(\App\Models\Product\Variation::class, rand(1, 3))->make([
                            'warranty_id' => $data['features']['warranties']->random()->id,
                            'color_id' => $data['features']['colors']->random()->id,
                        ])
                    )
                );
                
                // $this->variations->each( function( $variation ) {

                //     $variation->order_points()->saveMany(
                //         factory( App\Models\Financial\OrderPoint::class ,5)->make([
                //             'variation_id'  => $variation->id
                //         ])
                //     );
                // });

                // $variations->each( function($variation) use($promocodeUsers) {
                //     $id = [];
                    
                //     for( $i = 0 ; $i < rand(1,4) ; $i++ )
                //     {
                //         $id[] = $promocodeUsers->random()->id;
                //     }
                    
                //     $variations->promocode_User()->sync( $id );
                // }

                // $data['users']->each( function ( $user ) use ( $product, $data ) {
                //     $product->reviews()->save(
                //         factory(\App\Models\Opinion\Review::class)->make([
                //             'user_id' => $user->id
                //         ])
                //     );
                    
                //     $product->questions()->save(
                //         factory(App\Models\Opinion\QuestionAndAnswer::class)->make([
                //             'user_id' => $user->id
                //         ])
                //     )->each( function ($questionAndAnsers) use ( $data ) {
                //         $questionAndAnsers->answers()->saveMany(
                //             factory(\App\Models\Opinion\QuestionAndAnswer::class, rand(0, 5) )->make([
                //                 'user_id' => $data['users']->random()->id
                //             ])
                //         );
                //     });
                // });

                
                    
                $data['specifications']['rows']->each( function ( $spec_row ) use ( $product ) {

                    $product->spec_data()->save(
                        factory(\App\Models\Spec\SpecData::class)->make([
                            'spec_row_id'   => $spec_row->id,
                            'data'          => ($spec_row->values)
                                    ? rand(0, count($spec_row->values, true) - 1)
                                    : Faker::fullName()
                        ])
                    );
                });
            });
        });

        return [
            'products'      => $this->products,
            'variations'    => $this->variations,
        ];
    }
}