<?php

use Illuminate\Database\Seeder;

class PromocodeTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($data)
    {
        $promocodes = factory( App\Models\Promocode\Promocode::class, 5 )->create();
        
        $promocodes->each( function( $promocode ) use( $data ) {
           
            $promocode->categories()->sync( $data['categories']->random() );
        });

        $data['users']->each( function( $user ) use( $promocodes ) {

            $user->promocodes()->sync( $promocodes->random() );
        });

        return $promocodes;
    }
}
