<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( !\App\User::whereEmail('amirkh920@gmail.com')->first() )
        {
            \App\User::create([
                'first_name' => 'امیر',
                'last_name' => 'خدنگی',
                'email' => 'amirkh920@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 1
            ]);

            \App\User::create([
                'first_name' => 'صادق',
                'last_name' => 'صفری',
                'email' => 'grcg2000@Gmail.com',
                'password' => Hash::make('123456'),
                'type' => 1
            ]);
            
            \App\User::create([
                'first_name' => 'محمدرضا',
                'last_name' => 'پیخوش',
                'email' => 'salamon.1378@Gmail.com',
                'password' => Hash::make('123456'),
                'type' => 1
            ]);
        }
    }
}
