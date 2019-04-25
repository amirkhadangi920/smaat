<?php

use App\Helpers\CustomSeeder;

use App\Models\Group\Category;
use App\Models\Feature\Brand;
use App\Models\Feature\Unit;
use App\Models\Spec\Spec;
use App\Models\Feature\Warranty;
use App\Models\Feature\Color;
use App\Models\Feature\Size;
use App\Models\Promocode\Promocode;

class ProductTablesSeeder extends CustomSeeder
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
    public function run()
    {
        $categories = Category::all();
        if ( $categories->count() === 0 )
            return $this->command->error('Your havn\'t any categories :(');

        
        $categories->random()->each( function ( $category ) {

            $this->createProducts( $category );
            
            $this->products->each( function( $product ) {
                
                $this->createQuestionAndAnswers($product);
            });    
    
            $this->products->each(function ($product) {

                $this->variations = $this->variations->merge(
                    $variations = $product->variations()->saveMany(
                        factory(\App\Models\Product\Variation::class, rand(1, 5))->make([
                            'warranty_id'   => Warranty::all()->random()->id,
                            'color_id'      => Color::all()->random()->id,
                            'size_id'       => Size::all()->random()->id,
                        ])
                    )
                );
                
                $variations->each( function( $variation ) {
                    $variation->promocodes()->sync( Promocode::all()->random() );
                });
                
                $variations->each( function( $variation ) {
                    $variation->order_points()->saveMany(
                        factory(App\Models\Financial\OrderPoint::class, rand(1, 5) )->make() 
                    );
                });

                \App\User::all()->take( rand(5, 10) )->each( function ( $user ) use ( $product ) {

                    $product->reviews()->save(
                        factory(\App\Models\Opinion\Review::class)->make([
                            'user_id' => App\User::all()->random()->id
                        ])
                    );
                });
                

                Spec::first()->headers()->each( function($header) use($product) {

                    $header->rows()->each( function ( $spec_row ) use ( $product ) {

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
        });
        
        return [
            'products'      => $this->products,
            'variations'    => $this->variations,
        ];
    }

    public function createProducts( $category )
    {
        return $this->products = $this->createTable(

            function() use($category) {

                return $category->products()->saveMany(
                    factory(\App\Models\Product\Product::class, 5)->make([
                        'user_id'   => App\User::all()->random()->id,
                        'brand_id'  => Brand::all()->random()->id,
                        'unit_id'   => Unit::all()->random()->id,
                        'spec_id'   => Spec::all()->random()->id,  
                    ])
                );
            },
            [ 'id', 'name', 'code', 'user_id', 'status', 'brand_id', 'jalali_created_at' ],
            [], 'product'
        );
    }

    public function createQuestionAndAnswers($product)
    {
        return $this->createTable(
            function() use($product) {
                return $product->questions()->saveMany(
                    factory(\App\Models\Opinion\QuestionAndAnswer::class, rand(2, 5) )->make([
                        'user_id' => App\User::all()->random()->id,
                    ])
                )->each( function ($questionAndAnswer) {
                    $questionAndAnswer->answers()->saveMany(
                        factory(\App\Models\Opinion\QuestionAndAnswer::class, rand(5, 10) )->make([
                            'user_id' => App\User::all()->random()->id,
                        ])
                    );
                });
            },
            ['id', 'user_id', 'product_id'],
            [], 'question and answer', "for product {$product->id}"
        );
    }
}