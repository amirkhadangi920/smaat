<?php

use Illuminate\Database\Seeder;
use Ybazli\Faker\Facades\Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        echo "\n";

        // $this->call(AdminTableSeeder::class);

        // $cities = $this->call(LocationTablesSeeder::class);
        
        $this->call(OptionTableSeeder::class);
        
        $users = factory(\App\User::class, 5)->create([
            // 'city_id' => $cities->random()->id
        ]);
        echo "\e[31m\e[1m\e[100m{$users->count()}\e[49m Users \e[39mwas \e[32mcreated\n";
    
        $this->call(BlogTablesSeeder::class, $users);
        
        $categories = $this->call(CategoryTablesSeeder::class);

        // $categories->each( function( $category ) {
        // $category->order_points()->saveMany( 
        //     factory( App\Models\Financial\OrderItem::class, 5 )->make([
        //         'category_id'   => $category->id
        //         ])
        //     );
        // });    
        //     dd('lkajkldlka');
        $features = $this->call(FeatureTablesSeeder::class, $categories);
        
        $specifications = $this->call(SpecificationTablesSeeder::class, $categories);
        
        $promocodes = $this->call(PromocodeTablesSeeder::class, compact('users', 'categories'));

        $products = $this->call(ProductTablesSeeder::class, compact(
            'users', 'categories', 'specifications', 'features','promocodes'
        )); 

        $this->call(AbstractTablesSeeder::class, compact('users', 'products'));
        

        $this->call(OrderTablesSeeder::class, compact(
            'users', 'products', 'cities', 'promocodes', 'categories'
        ));
    }

    /**
     * Override the DatabaseSeder call method
     *
     * @param Seeder $class
     * @param mixed $extra
     * @return mixed $result
     */
    public function call($class, $extra = null)
    {
        $result = $this->resolve($class)->run($extra);
        if (isset($this->command)) {
            $this->command->getOutput()->writeln("<info>Seeded:</info> $class");
        }

        return $result;
    }
}
