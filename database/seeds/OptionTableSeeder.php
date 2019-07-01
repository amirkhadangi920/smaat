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
                    'name' => 'slider',
                    'value' => json_encode([
                        [
                            'image' => '/test_theme/slider/master-slide-01.jpg',
                            'title' => 'عنوان اسلایدر شماره ۱',
                            'description' => 'توضیحاتی کوتاه درباره ی اسلایدر شماره ۱',
                            'button' => 'متن دکمه شماره ۱',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/slider/master-slide-02.jpg',
                            'title' => 'عنوان اسلایدر شماره ۲',
                            'description' => 'توضیحاتی کوتاه درباره ی اسلایدر شماره ۲',
                            'button' => 'متن دکمه شماره ۲',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/slider/master-slide-03.jpg',
                            'title' => 'عنوان اسلایدر شماره ۳',
                            'description' => 'توضیحاتی کوتاه درباره ی اسلایدر شماره ۳',
                            'button' => 'متن دکمه شماره ۳',
                            'link' => '#'
                        ],
                        ])
                ], [
                    'name' => 'posters',
                    'value' => json_encode([
                        [
                            'image' => '/test_theme/posters/banner-02.jpg',
                            'title' => 'عنوان پوستر شماره ۱',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۱',
                            'button' => 'متن دکمه شماره ۱',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/posters/banner-03.jpg',
                            'title' => 'عنوان پوستر شماره ۲',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۲',
                            'button' => 'متن دکمه شماره ۲',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/posters/banner-04.jpg',
                            'title' => 'عنوان پوستر شماره ۳',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۳',
                            'button' => 'متن دکمه شماره ۳',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/posters/banner-05.jpg',
                            'title' => 'عنوان پوستر شماره ۴',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۴',
                            'button' => 'متن دکمه شماره ۴',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/posters/banner-07.jpg',
                            'title' => 'عنوان پوستر شماره ۵',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۵',
                            'button' => 'متن دکمه شماره ۵',
                            'link' => '#'
                        ],
                        [
                            'image' => '/test_theme/posters/banner-08.jpg',
                            'title' => 'عنوان پوستر شماره ۶',
                            'description' => 'توضیحاتی کوتاه درباره ی پوستر شماره ۶',
                            'button' => 'متن دکمه شماره ۶',
                            'link' => '#'
                        ],
                    ])
                ], [
                    'name' => 'watermark',
                    'value' => '/test_theme/watermark.jpg'
                ], [
                    'name' => 'logo',
                    'value' => '/test_theme/logo.png'
                ], [
                    'name' => 'banner',
                    'value' => '/test_theme/watermark.jpg'
                ], [
                    'name' => 'header_banner',
                    'value' => '/test_theme/header_banner.jpg'
                ], [
                    'name' => 'theme_color',
                    'value' => '#4286f4'
                ], [
                    'name' => 'is_enabled',
                    'value' => true
                ], 
            ];

            foreach ( $data as $item )
                \App\Models\Option\SiteSetting::create( $item );

            echo "\e[31mWebsite options \e[39mwas \e[32mcreated\n";
        }
    }
}
