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
        $categories = factory(\App\Models\Group\Category::class, rand(1, 5) )->create();
        $categories->each( function ( $category ) use ( &$categories ) {

            $categories = $categories->merge( $category->childs()->saveMany(
                factory(\App\Models\Group\Category::class, rand(1, 5) )->make()
            ));
        });
        
        $categories->each( function( $category ) {
            $category->order_points()->saveMany( 
                factory( App\Models\Financial\OrderPoint::class, rand(1, 5) )->make()
                );
            });
    
        return $categories;
    }
}
