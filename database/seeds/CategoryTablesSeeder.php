<?php

use Illuminate\Database\Seeder;
use App\Models\Group\Category;

class CategoryTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::where('id', '>', 0)->delete();
        $this->command->info('All The categories was deleted');
        
        $categories = collect([
            [
                'title' => 'کالای دیجیتال',
                'childs' => [
                    [
                        'title' => 'لوازم جانبی',
                        'childs' => [
                            [
                                'title' => 'کیف و کاور گوشی',
                            ],
                            [
                                'title' => 'پاور بانک',
                            ],
                            [
                                'title' => 'هندزفری ، هدفون ، هدست',
                            ],
                            [
                                'title' => 'پایه نگهدارنده گوشی',
                            ]
                        ]
                    ], [
                        'title' => 'گوشی موبایل',
                        'childs' => [
                            [
                                'title' => 'هوآوی',
                            ],
                            [
                                'title' => 'اپل',
                            ],
                        ]
                    ], [
                        'title' => 'واقعیت مجازی',
                    ], [
                        'title' => 'مچ بند و ساعت',
                    ], [
                        'title' => 'دوربین',
                        'childs' => [
                            [
                                'title' => 'دوربین عکاسی دیجیتال',
                            ],
                            [
                                'title' => 'دوربن ورزشی و فیلم برداری',
                            ],
                            [
                                'title' => 'دوربین چاپ سریع',
                            ],
                        ]
                    ], [
                        'title' => ' دوربین های تحت شبکه',
                    ], [
                        'title' => 'لپ تاپ',
                    ], [
                        'title' => 'مودم و تجهیزات شبکه',
                    ], [
                        'title' => 'کامپیوتر و تجهیزات جانبی',
                        'childs' => [
                            [
                                'title' => 'تجهیزات مخصوص بازی',
                            ],
                            [
                                'title' => 'مانیتور',
                            ],
                            [
                                'title' => 'کیس های اسمبل شده',
                            ],
                            [
                                'title' => 'قطعات داخلی کامپیوتر',
                            ],
                            [
                                'title' => 'ماوس',
                            ],
                        ]
                    ], [
                        'title' => 'تبلت',
                        'childs' => [
                            [
                                'title' => 'لنوو',
                            ],
                            [
                                'title' => 'سامسونگ',
                            ],
                            [
                                'title' => 'ایسوس',
                            ],
                        ]
                    ], [
                        'title' => 'ماشین های اداری',
                        'childs' => [
                            [
                                'title' => 'لوازم جانبی پرینتر',
                            ],
                            [
                                'title' => 'تلفن بیسیم و سانترال',
                            ],
                            [
                                'title' => 'فکس',
                            ],
                            [
                                'title' => 'پرینتر',
                            ],
                            [
                                'title' => 'لیبل زن حرارتی',
                            ],
                        ]
                    ]
                ]
            ], [
                'title' => 'آرایشی و بهداشتی',
            ], [
                'title' => 'خودرو، ابزار و اداری',
            ], [
                'title' => 'مد و پوشاک',
            ], [
                'title' => 'خانه و پوشاک',
            ], [
                'title' => 'فرهنگ و هنر',
            ], [
                'title' => 'اسباب بازی و کودک',
            ], [
                'title' => 'ورزش و سفر',
            ], [
                'title' => 'خوردنی و آشامیدنی',
            ]
        ]);

        
        $categories->each( function($category) {

            $this->createCategoryWithChilds($category);       
        });
    }

    public function createCategoryWithChilds($category)
    {
        $result = factory(Category::class)->create([
            'title' => $category['title']
        ]);


        if ( isset( $category['childs'] ) && count( $category['childs'] ) !== 0 )
        {
            $childs = array_map( function($child) {
                return factory(Category::class)->make([ 'title' => $child['title'] ]);
            }, $category['childs']);
            
            
            $result->childs()->saveMany( $childs );
    
            $result->childs->each( function($category) {
    
                $this->createCategoryWithChilds($category);       
            });
        }

    }
}
