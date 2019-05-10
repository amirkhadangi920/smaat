<?php
use App\Helpers\CustomSeeder;

class DatabaseSeeder extends CustomSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // for ( $i = 0; $i < 300; ++$i ) {
        //     $this->call(ProductTablesSeeder::class);
        // }
        // return;

        // $this->call(AdminTableSeeder::class);

        $this->call(LocationTablesSeeder::class);

        // $this->call(OptionTableSeeder::class);

        $this->call(UserTableSeeder::class);
    
        $this->call(BlogTablesSeeder::class);

        $this->call(CategoryTablesSeeder::class);

        $this->call(FeatureTablesSeeder::class);
        
        $this->call(SpecificationTablesSeeder::class);
        
        $this->call(PromocodeTablesSeeder::class);

        $this->call(ProductTablesSeeder::class); 

        $this->call(AbstractTablesSeeder::class);
        
        $this->call(OrderTablesSeeder::class);
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
