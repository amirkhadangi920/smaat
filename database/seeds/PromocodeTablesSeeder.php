<?php

use Illuminate\Database\Seeder;
use App\Models\Group\Category;

class PromocodeTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promocodes = factory( App\Models\Promocode\Promocode::class, rand(1, 5) )->create();
        
        $promocodes->each( function( $promocode ) {
           
            $promocode->categories()->sync( Category::all()->random() );
        });

        App\User::latest()->get()->take(10)->each( function( $user ) use( $promocodes ) {

            $user->promocodes()->sync( $promocodes->random() );
        });

        return $promocodes;
    }
}
