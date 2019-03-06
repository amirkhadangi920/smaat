<?php

use Illuminate\Database\Seeder;

class CategoryTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = factory(\App\Models\Group\Category::class, 2)->create();
        $categories->each( function ( $category ) use ( &$categories ) {

            $categories = $categories->merge( $category->childs()->saveMany(
                factory(\App\Models\Group\Category::class, 2)->make()
            ));
        });
        
        $categories->each( function( $category ) {
            $category->order_points()->saveMany( 
                factory( App\Models\Financial\OrderPoint::class, 5 )->make()
                );
            });
    
        return $categories;
    }
}
