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
        $this->command->alert("Try to creating users");

        $users = factory(\App\User::class, rand(20, 50) )->create([
            'city_id' => City::all()->isEmpty() ? null : City::all()->random()->id
        ]);

        $this->command->table(['id', 'email'], $users->map(function($user) {
            return [
                $user->id,
                $user->email
            ];
        }));
        
        $this->command->info($users->count()." users was created");
    }
}
