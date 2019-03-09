<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $data )
    {
        $users = factory(\App\User::class, 10)->create([
            // 'city_id' => $data['cities']->random()->id
        ]);

        return $users;
    }
}
