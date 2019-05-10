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

        $spec = Spec::all()->random();

        $this->createProducts( $categories->random(),  $spec->id);

        $this->createQuestionAndAnswers( $this->products->random() );
        $this->products->each(function ($product) use($spec) {

            $variations = $this->createVariations($product);

            $variations->each( function( $variation ) {
                $variation->promocodes()->sync( Promocode::all()->random() );
            });
            
            $variations->each( function( $variation ) {
                $variation->order_points()->saveMany(
                    factory(App\Models\Financial\OrderPoint::class, rand(1, 5) )->make() 
                );
            });

            \App\User::all()->take( rand(5, 10) )->each( function($user) use ( $product ) {
                $product->reviews()->save(
                    factory(\App\Models\Opinion\Review::class)->make([
                        'user_id' => $user->id
                    ])
                );
            });
            
            $spec->headers->each( function($header) use($product) {
                
                $header->rows->each( function( $spec_row ) use($product) {

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
    }

    public function createProducts($category, $spec_id)
    {
        return $this->products = $this->createTable(

            function() use($category, $spec_id) {

                return $category->products()->saveMany(
                    factory(\App\Models\Product\Product::class, 1)->make([
                        'user_id'   => App\User::all()->random()->id,
                        'brand_id'  => Brand::all()->random()->id,
                        'unit_id'   => Unit::all()->random()->id,
                        'spec_id'   => $spec_id,  
                    ])
                );
            },
            [ 'id', 'name', 'code', 'user_id', 'status', 'brand_id', 'jalali_created_at' ],
            [], 'product'
        );
    }

    public function createVariations($product)
    {
        return $this->variations = $this->createTable(
            function() use($product) {
                return $product->variations()->saveMany(
                    factory(\App\Models\Product\Variation::class, 1)->make([
                        'warranty_id'   => Warranty::all()->random()->id,
                        'color_id'      => Color::all()->random()->id,
                        'size_id'       => Size::all()->random()->id,
                    ])
                );
            },
            [ 'id', 'inventory', 'sales_price', 'warranty_id', 'color_id', 'size_id', 'sending_time' ],
            [], 'variation'
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