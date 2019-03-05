<?php

use Illuminate\Database\Seeder;

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
    public function run( $categories )
    {
        $spec = factory(\App\Models\Spec\Spec::class)->create([
            'category_id' => $categories->random()->id
        ]);

        factory(\App\Models\Spec\SpecHeader::class, 2)->create([
            'spec_id' => $spec->id
        ])->each( function ( $spec_header ) use ( $spec ) {

            $this->spec_rows = $this->spec_rows->merge(
                factory(\App\Models\Spec\SpecRow::class, 3)->create([
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
