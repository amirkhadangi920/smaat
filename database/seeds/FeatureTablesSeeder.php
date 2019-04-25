<?php

use App\Helpers\CustomSeeder;
use App\Models\Group\Category;
use App\Models\Feature\{ 
    Color,
    Warranty,
    Brand,
    Size,
    Unit
};
use Illuminate\Support\Str;

class FeatureTablesSeeder extends CustomSeeder
{
    protected $categories;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tenant_id = $this->getTenant();
        $this->categories = Category::all()->take(20);

        $this->createData(Color::class, ['id', 'name', 'code']);
        $this->createData(Warranty::class , ['id', 'title', 'expire']);
        $this->createData(Brand::class, ['id', 'name']);
        $this->createData(Size::class, ['id', 'name']);
        $this->createData(Unit::class, ['id', 'title']);
    }

    public function createData($model, $fields = ['id'])
    {
        $this->createTable(
            function($count) use($model, $fields) {
                return factory($model, $count)->create([
                    'tenant_id' => $this->tenant_id
                ])->each( function ( $feature ) {
        
                    $feature->categories()->sync( $this->categories->take( rand(1, 5) )->pluck('id') );
                });
            },
            $fields, [], str_replace('-', ' ', Str::kebab( class_basename($model) ))
        );
    }
}
