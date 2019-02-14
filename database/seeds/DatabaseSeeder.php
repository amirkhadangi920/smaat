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

        if ( !\App\User::whereEmail('AmirKhadangi920@Gmail.com')->first() )
        {
            \App\User::create([
                'first_name' => 'امیر',
                'last_name' => 'خدنگی',
                'phones' => [
                    [ 'type' => 'main', 'value' => '09105009868' ]
                ],
                'email' => 'AmirKhadangi920@Gmail.com',
                'password' => Hash::make('123456'),
                'address' => 'سناباد 44 ، ساختمان 52',
                'postal_code' => '1234567890',
                'type' => 1
            ]);
            echo "\e[31mAmir Khadangi user \e[39mwith id=\e[30m\e[101m3g6s316j\e[49m \e[39mwas \e[32mcreated\n";
        }

        $cities = $this->call(LocationTablesSeeder::class);
        $this->call(OptionTableSeeder::class);
        
        $users = factory(\App\User::class, 5)->create([
            'city_id' => $cities->random()->id
        ]);
        echo "\e[31m\e[1m\e[100m{$users->count()}\e[49m Users \e[39mwas \e[32mcreated\n";
    
        $this->call(BlogTablesSeeder::class, $users);

        $categories = factory(\App\Models\Group\Category::class, rand(1,5))->create();
        $categories->each( function ( $category ) use ( &$categories ) {

            $categories = $categories->merge( $category->childs()->saveMany(
                factory(\App\Models\Group\Category::class, rand(0,3))->make()
            ));
        });

        $features = $this->call(FeatureTablesSeeder::class, $categories);
        
        $specifications = $this->call(SpecificationTablesSeeder::class, $categories);

        $products = $this->call(ProductTablesSeeder::class, compact('users', 'categories', 'specifications', 'features'));
        
        // Add favorites products for the users
        $users->each( function ( $user ) use ( $products ) {

            for( $i = 0; $i < rand(0, 3); ++$i )
            {
                $user->favorites()->attach( $products['products']->random() );
            }
        });

        // Add Accesories for the products
        $products['products']->each( function ( $product ) use ( $products ) {

            for( $i = 0; $i < rand(0, 3); ++$i )
            {
                $product->accessories()->attach( $products['products']->random() );
            }
        });

        $this->call(OrderTablesSeeder::class, compact('users', 'products'));

        echo "\n";
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
