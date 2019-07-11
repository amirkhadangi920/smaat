<?php

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Helpers\CustomSeeder;
use App\User;
use Illuminate\Support\Str;
use App\Role;

class CreateTenantSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('cache:clear');
        
        $tenant_name = $this->command->ask('Write your tenants name ');
        $owner_name = $this->command->ask('Write your tenants Owner ');
                

        $tenant = new Tenant;
        $tenant->user_id = null;
        $tenant->title = 'وبسایت ' . $owner_name;
        $tenant->save();

        $tenant->hostnames()->create([
            'domain' => "{$tenant_name}.ir"
        ]);


        $user = new User;
        $user->tenant_id = $tenant->id;
        $user->first_name = explode(' ', $owner_name)[0] ?? '';
        $user->last_name = explode(' ', $owner_name)[1] ?? '';
        $user->email = Str::replaceFirst(' ', '', $owner_name) . '@smaat.ir';
        $user->password = bcrypt('123456');
        $user->save();

        $tenant->user_id = $user->id;
        $tenant->save();

        $user->attachRole('owner');

        $this->command->table(
            ['tenant_id', 'domain', 'owner_email', 'owner_id'],
            [
                [$tenant->id, $tenant->hostnames()->first()->domain, $user->email, $user->id]
            ]
        );
    }
}
