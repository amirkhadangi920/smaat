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
        
        $shippings = factory( App\Models\Shipping_method::class, 5 )->create();

        $order_statuses = factory( App\Models\Financial\OrderStatus::class , 6 )->create();
        
        $orders = factory(\App\Models\Financial\Order::class, rand(5, 20))->create([
            
            'user_id'              => $data['users']->random()->id,
            'shipping_method_id'    => $shippings->random()->id,
            // 'city_id'            => $data['cities']->random()->id,
            'order_status_id'       => $order_statuses->random()->id,
            'promocode_id'          => $data['promocodes']->random()->id,
        ]);
            
        
        $data['products']['variations']->each( function ( $variation ) use ( $orders ) {
            
            $orders->random()->items()->save(
                factory(\App\Models\Financial\OrderItem::class)->make([
                    'variation_id'  => $variation->id,
                    'price'         => $variation->sales_price,
                    'order_id'      => $orders->random()->id
                ])
            );
        });

        
        
        $discounts = factory(\App\Models\Discount\Discount::class, rand(1, 5))->create([
            'user_id' => $data['users']->random()->id
        ]);

        

        $data['products']['variations']->each( function ( $variation ) use ( $discounts ) {

            $discounts->random()->discount_items()->saveMany( 
                factory( App\Models\Discount\DiscountItem::class, 5 )->make([

                    'discount_id'    => $discounts->random()->id,
                    'variation_id'  => $variation->id,
                ])
            );  
        }); 
    }
}
