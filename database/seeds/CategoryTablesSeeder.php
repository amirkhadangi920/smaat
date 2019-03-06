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
        
        return $categories;
    }
}
