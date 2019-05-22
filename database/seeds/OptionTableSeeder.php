<?php

use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if ( \App\Models\Option::all()->isEmpty() )
        {
            $data = [
                [
                    'name' => 'slider',
                    'value' => "[{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0634\\u0645\\u0627\\u0631\\u0647 \\u06f1\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u062a\\u0635\\u0627\\u062f\\u0641\\u06cc \\u0627\\u0633\\u0644\\u0627\\u06cc\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 \\u06f1\",\"link\":\"http:\\/\\/hicostore\\/link1\",\"button\":\"\\u062e\\u0631\\u06cc\\u062f \\u06a9\\u0646\\u06cc\\u062f\",\"photo\":\"f9f28eaa.jpg\"},{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0634\\u0645\\u0627\\u0631\\u0647 2 \\u0627\\u0635\\u0644\\u0627\\u062d \\u0634\\u062f\\u0647\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u062a\\u0635\\u0627\\u062f\\u0641\\u06cc \\u0627\\u0633\\u0644\\u0627\\u06cc\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 2\",\"link\":\"http:\\/\\/hicostore\\/link2\",\"button\":\"\\u062f\\u06a9\\u0645\\u0647 2\",\"photo\":\"e8dd6566.jpg\"},{\"title\":\"\\u0639\\u0646\\u0648\\u0627\\u0646 \\u0634\\u0645\\u0627\\u0631\\u0647 3\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u062a\\u0635\\u0627\\u062f\\u0641\\u06cc \\u0627\\u0633\\u0644\\u0627\\u06cc\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 3\",\"link\":\"http:\\/\\/hicostore\\/link3\",\"button\":\"\\u062f\\u06a9\\u0645\\u0647 3\",\"photo\":\"312a4973.jpg\"}]",
                ], [
                    'name' => 'posters',
                    'value' => "[{\"title\":\"\\u067e\\u0648\\u0633\\u062a\\u0631 1\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u067e\\u0648\\u0633\\u062a\\u0631 \\u0634\\u0645\\u0627\\u0631\\u0647 1\",\"link\":\"http:\\/\\/hicostore\\/link1\",\"button\":\"\\u062f\\u06a9\\u0645\\u0647 \\u0634\\u0645\\u0627\\u0631\\u0647 1\",\"photo\":\"3c52cb59.jpeg\"},{\"title\":\"\\u067e\\u0648\\u0633\\u062a\\u0631 2\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u067e\\u0648\\u0633\\u062a\\u0631 \\u0634\\u0645\\u0627\\u0631\\u0647 2\",\"link\":\"http:\\/\\/hicostore\\/link2\",\"button\":\"\\u062f\\u06a9\\u0645\\u0647 \\u0634\\u0645\\u0627\\u0631\\u0647 2\",\"photo\":\"11d55624.jpg\"},{\"title\":\"\\u067e\\u0648\\u0633\\u062a\\u0631 3\",\"description\":\"\\u062a\\u0648\\u0636\\u06cc\\u062d \\u067e\\u0648\\u0633\\u062a\\u0631 \\u0634\\u0645\\u0627\\u0631\\u0647 3\",\"link\":\"http:\\/\\/hicostore\\/link3\",\"button\":\"\\u062f\\u06a9\\u0645\\u0647 \\u0634\\u0645\\u0627\\u0631\\u0647 3\",\"photo\":\"27968418.jpg\"}]",
                ], [
                    'name' => 'site_name',
                    'value' => 'HiCO Store',
                ], [
                    'name' => 'site_description',
                    'value' => 'این یک توضیح خیلی کوتاه و تصادفی درباره فروشگاه و کسب و کار کوچک هایکو استور میباشد که توسط مدیر قابل تعویض است',
                ], [
                    'name' => 'site_logo',
                    'value' => 'b0fae1e6.png',
                ], [
                    'name' => 'watermark',
                    'value' => 'b0fae1e6.png',
                ], [
                    'name' => 'watermark',
                    'value' => 'b0fae1e6.png',
                ], [
                    'name' => 'watermark',
                    'value' => 'b0fae1e6.png',
                ], [
                    'name' => 'shop_phone',
                    'value' => '09123456789',
                ], [
                    'name' => 'min_total',
                    'value' => '100000',
                ], [
                    'name' => 'shop_address',
                    'value' => 'خراسان رضوی ، مشهد ، بین دستغیب 15 و 17 ، پلاک 231 ، واحد 1',
                ], [
                    'name' => 'social_link',
                    'value' => "{\"instagram\":\"https:\\/\\/instagram.com\\/\",\"telegram\":\"https:\\/\\/telegram.com\\/\",\"facebook\":\"https:\\/\\/facebook.com\\/\",\"twitter\":\"https:\\/\\/twitter.com\"}",
                ], [
                    'name' => 'dollar_cost',
                    'value' => '14500',
                ], [
                    'name' => 'shipping_cost',
                    'value' => "{\"model1\":{\"name\":\"\\u0645\\u062a\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 \\u06cc\\u06a9\",\"cost\":\"5000\"},\"model2\":{\"name\":\"\\u0645\\u062a\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 \\u062f\\u0648\",\"cost\":\"14000\"},\"model3\":{\"name\":\"\\u0645\\u062a\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 \\u0633\\u0647\",\"cost\":\"8000\"},\"model4\":{\"name\":\"\\u0645\\u062a\\u062f \\u0634\\u0645\\u0627\\u0631\\u0647 \\u0686\\u0647\\u0627\\u0631\",\"cost\":\"5000\"}}",
                ]
            ];

            foreach ( $data as $item )
                \App\Models\Option::create( $item );

            echo "\e[31mWebsite options \e[39mwas \e[32mcreated\n";
        }
    }
}
