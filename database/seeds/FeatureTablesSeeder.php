<?php

use Illuminate\Database\Seeder;

class FeatureTablesSeeder extends Seeder
{
    /**
     * Array of features data, e.g colors, brand etc ...
     *
     * @var array
     */
    private $data;

    public function __construct()
    {
        $this->data = [
            'colors'        => collect(),
            'brands'        => collect(),
            'sizes'         => collect(),
            'warranties'    => collect(),
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $categories )
    {
        $categories->each( function ( $category ) {

            $this->data['colors'] = $this->data['colors']->merge(
                $category->colors()->saveMany(
                    factory(\App\Models\Feature\Color::class, rand(1, 10))->make()
                )
            );
    
            $this->data['warranties'] = $this->data['warranties']->merge(
                $category->warranties()->saveMany(
                    factory(\App\Models\Feature\Warranty::class, rand(1, 10))->make()
                )
            );

            $this->data['brands'] = $this->data['brands']->merge(
                $category->brands()->saveMany(
                    factory(\App\Models\Feature\Brand::class, rand(1, 10))->make()
                )
            );

            $this->data['sizes'] = $this->data['sizes']->merge(
                $category->sizes()->saveMany(
                    factory(\App\Models\Feature\Size::class, rand(1, 10))->make()
                )
            );
            
            echo "\e[31mAll the features \e[39mfor category=\e[30m\e[101m{$category->id}\e[49m \e[39mwas \e[32mcreated\n";
        });


        return $this->data;
    }
}
