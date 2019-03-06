<?php

use Illuminate\Database\Seeder;

class FeatureTablesSeeder extends Seeder
{
    protected $data;

    protected $categories;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $categories )
    {
        $this->categories = $categories;

        $this->createData('colors', \App\Models\Feature\Color::class);
        $this->createData('warranties', \App\Models\Feature\Warranty::class);
        $this->createData('brands', \App\Models\Feature\Brand::class);
        $this->createData('sizes', \App\Models\Feature\Size::class);
        $this->createData('units', \App\Models\Feature\Unit::class);

        return $this->data;
    }

    public function createData($key, $model)
    {
        $categories = $this->categories;

        $this->data[ $key ] = factory($model, rand(1, 10))->create()
            ->each( function ( $feature ) use ( $categories ) {

                $feature->categories()->sync( $categories->take( rand(1, 5) )->pluck('id') );
            });
    }
}
