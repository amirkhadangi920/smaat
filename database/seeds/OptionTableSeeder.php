<?php

use Illuminate\Database\Seeder;
use function GuzzleHttp\json_encode;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if ( \App\Models\Option\SiteSetting::all()->isEmpty() )
        {
            $data = [
                [
                    'name' => 'title',
                    'value' => 'فروشگاه SmaaT shop',
                ], [
                    'name' => 'description',
                    'value' => 'این یک توضیح خیلی کوتاه و تصادفی درباره فروشگاه و کسب و کار شما میباشد که توسط مدیر قابل تعویض است',
                ], [
                    'name' => 'phone',
                    'value' => '09123456789',
                ], [
                    'name' => 'address',
                    'value' => 'خراسان رضوی ، مشهد ، بین دستغیب 15 و 17 ، پلاک 231 ، واحد 1',
                ], [
                    'name' => 'theme_color',
                    'value' => '#4286f4'
                ]
            ];

            foreach ( $data as $item )
                \App\Models\Option\SiteSetting::create( $item );

            echo "\e[31mWebsite options \e[39mwas \e[32mcreated\n";
        }
    }
}
