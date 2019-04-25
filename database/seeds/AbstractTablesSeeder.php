<?php

use Illuminate\Database\Seeder;
use App\Models\Product\Product;

class AbstractTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::latest()->get()->take(10);
        $products = Product::latest()->get()->take(20);

        // Add favorites products for the users
        $users->each( function ( $user ) use ($products) {

            $user->favorites()->sync( $products->take( rand(1, 10)) );
        });

        // Add Accesories for the products
        $products->each( function ( $product ) use ( $products ) {

            $product->accessories()->sync( $products->take( rand(1, 10)) );
        });
    }
}
