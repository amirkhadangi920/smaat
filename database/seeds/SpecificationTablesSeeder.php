<?php

use Illuminate\Database\Seeder;
use App\Models\Group\Category;

class SpecificationTablesSeeder extends Seeder
{
    /**
     * specification table rows store in this var
     * for using when create product's specification table data
     *
     * @var null
     */
    public $spec_rows;

    public function __construct()
    {
        $this->spec_rows = collect();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::latest()->get()->take(10);

        $spec = factory(\App\Models\Spec\Spec::class)->create([
            'category_id' => $categories->random()->id
        ]);

        factory(\App\Models\Spec\SpecHeader::class, rand(1, 5) )->create([
            'spec_id' => $spec->id
        ])->each( function ( $spec_header ) {

            $this->spec_rows = $this->spec_rows->merge(
                factory(\App\Models\Spec\SpecRow::class, rand(1, 5) )->create([
                    'spec_header_id' => $spec_header->id
                ])
            );
        });

        return [
            'rows'          => $this->spec_rows,
            'spec_table'    => $spec->id
        ];
    }
}
