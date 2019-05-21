<?php

use Illuminate\Database\Seeder;
use App\Models\Group\Category;

class CategoryTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::where('id', '>', 0)->delete();
        $this->command->info('All The categories was deleted');

        return factory( \App\Models\Group\Category::class, 15)->create()->each( function($category) {
            
            $category->childs()->saveMany(
                factory( \App\Models\Group\Category::class, rand(0, 6))->make()
            )->each( function($category) {
    
                $category->childs()->saveMany(
                    factory( \App\Models\Group\Category::class, rand(0, 4))->make()
                )->each( function($category) {
    
                    $category->childs()->saveMany(
                        factory( \App\Models\Group\Category::class, rand(0, 3))->make()
                    )->each( function($category) {
    
                        $category->childs()->saveMany(
                            factory( \App\Models\Group\Category::class, rand(0, 2))->make()
                        )->each( function($category) {
    
                            $category->childs()->saveMany(
                                factory( \App\Models\Group\Category::class, rand(0, 2))->make()
                            );
                        });
                    });
                });
            });
        });
    }
}
