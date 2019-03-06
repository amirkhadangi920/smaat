<?php

use Illuminate\Database\Seeder;

class ProductTablesSeeder extends Seeder
{
    public $products;

    public $variations;

    public $questionAndAnswers;

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

                factory(\App\Models\Product\Product::class, rand(1, 5))->make([
                    'user_id' => $data['users']->random()->id,
                    'brand_id' => $data['features']['brands']->random()->id,
                    'spec_id' => $data['specifications']['spec_table']
                ])

            )->each( function( $product ) use ( $data ){
                 $product->questions()->save(
                     factory(\App\Models\Opinion\QuestionAndAnswer::class)->make([
                    'user_id' => $data['users']->random()->id
                    ])
                );
            });    

            // $questionAndAnswers = $this->$questionAndAnswers->each( function (&$questionAndAnswer) use ( $data ) {
            //     $questionAndAnswer->answers()->save(
            //         factory(\App\Models\Opinion\QuestionAndAnswer::class)->make([
            //             'user_id' => $data['users']->random()->id
            //         ])
            //     );
            
            // });
    
            $this->products->each(function ($product) use ( $data ) {

                $this->variations = $this->variations->merge(
                    $variations = $product->variations()->saveMany(
                        factory(\App\Models\Product\Variation::class, rand(1, 5))->make([
                            'warranty_id' => $data['features']['warranties']->random()->id,
                            'color_id' => $data['features']['colors']->random()->id,
                        ])
                    )
                );
                
                $variations->each( function( $variation ) use( $data ) {
                    $variation->promocodes()->sync( $data['promocodes']->random() );
                });

                $variations->each( function( $variation ) {
                    $variation->order_points()->saveMany(
                        factory(App\Models\Financial\OrderPoint::class, 5)->make() 
                    );
                });

                $data['users']->each( function ( $user ) use ( $product, $data ) {

                    $product->reviews()->save(
                        factory(\App\Models\Opinion\Review::class)->make([
                            'user_id' => $data['users']->random()->id
                        ])
                    );
                });
               //     // echo $user->id.PHP_EOL;
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