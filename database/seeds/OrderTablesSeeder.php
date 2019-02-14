<?php

use Illuminate\Database\Seeder;

class OrderTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $data )
    {
        $orders = factory(\App\Models\Order\Order::class, rand(5, 20))->create([
            'buyer_id' => $data['users']->random()->id
        ]);
        
        $discount_codes = factory(\App\Models\Order\DiscountCode::class, rand(1, 5))->create([
            'user_id' => $data['users']->random()->id
        ]);

        $data['products']['variations']->each( function ( $variation ) use ( $orders ) {
            
            $orders->random()->items()->save(
                factory(\App\Models\Order\OrderItem::class)->make([
                    'variation_id'  => $variation->id,
                    'price'         => $variation->price,
                    'offer'         => $variation->offer
                ])
            );
        });
    }
}
