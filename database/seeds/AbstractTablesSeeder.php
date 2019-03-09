<?php

use Illuminate\Database\Seeder;

class AbstractTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($data)
    {
        // Add favorites products for the users
        $data['users']->each( function ( $user ) use ( $data ) {

            for( $i = 0; $i < rand(1, 5); ++$i )
            {
                $user->favorites()->sync( $data['products']['products']->random() );
            }
        });

        // Add Accesories for the products
        $data['products']['products']->each( function ( $product ) use ( &$data ) {

            for( $i = 0; $i < rand(1, 5); ++$i )
            {
                $product->accessories()->sync( $data['products']['products']->random() );
            }
        });
    }
}
