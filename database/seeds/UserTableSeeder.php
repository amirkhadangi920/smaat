<?php

use Illuminate\Database\Seeder;
use App\Models\Places\City;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(\App\User::class, 10)->create([
            'city_id' => City::all()->random()->id
        ]);

        return $users;
    }
}
