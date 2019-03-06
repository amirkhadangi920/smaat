<?php

use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ( !\App\User::whereEmail('AmirKhadangi920@Gmail.com')->first() )
        {
            \App\User::create([
                'first_name' => 'امیر',
                'last_name' => 'خدنگی',
                'phones' => [
                    [ 'type' => 'main', 'value' => '09105009868' ]
                ],
                'email' => 'AmirKhadangi920@Gmail.com',
                'password' => Hash::make('123456'),
                'address' => 'سناباد 44 ، ساختمان 52',
                'postal_code' => '1234567890',
                'type' => 1
            ]);
            echo "\e[31mAmir Khadangi user \e[39mwith id=\e[30m\e[101m3g6s316j\e[49m \e[39mwas \e[32mcreated\n";
        }
    }
}
