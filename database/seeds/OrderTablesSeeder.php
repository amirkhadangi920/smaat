<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $data )
    {
        
        // $orders = factory(\App\Models\Financial\Order::class, rand(5, 20))->create([
        //     'buyer_id' => $data['users']->random()->id
        // ]);

        // $data['products']['variations']->each( function ( $variation ) use ( $orders ) {
            
        //     $orders->random()->items()->save(
        //         factory(\App\Models\Financial\OrderItem::class)->make([
        //             'variation_id'  => $variation->id,
        //             'price'         => $variation->price,
        //             // 'order_id'      => $orders->random()->id
        //         ])
        //     );
        // });

        factory( App\Models\Financial\OrderStatus::class , 6 )->create();
        
        $discounts = factory(\App\Models\Discount\Discount::class, rand(1, 5))->create([
            'user_id' => $data['users']->random()->id
        ]);


        // $data['products']['variations']->each( function ( $variation ) use ( $discounts ) {

        //     $discounts->discount_items()->saveMany( 
        //         factory( App\Models\Discount\DiscountItem::class,5 )->make([

        //             'discout_id'    => $discounts->random()->id,
        //             'variation_id'  => $variation->id,
        //         ])
        //     );  
        // }); 
    }
}
