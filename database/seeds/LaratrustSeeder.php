<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Helpers\CustomSeeder;

class LaratrustSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $usernames = collect();
        while(true)
        {
            $usernames->push( $this->command->ask('Please enter an Email address ', "admin". ( $usernames->count() + 1 ) ."@site.com") );

            if ( $usernames->last() === 'end' )
            {
                $usernames->pop();
                break;
            };
        }

        while(true)
        {
            $password = $this->command->secret('Please Enter an password ');
            
            if ( !is_null($password) ) break;
        }

        $this->command->info('Truncating User, Role and Permission tables');
        $this->truncateLaratrustTables();

        $config = config('laratrust_seeder.role_structure');
        $userPermission = config('laratrust_seeder.permission_structure');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));
        $actionsLabel = collect(config('laratrust_seeder.actions_label'));
        $permissionsLabel = collect(config('laratrust_seeder.permissions_label'));
        $roleLabel = collect(config('laratrust_seeder.roles_label'));

        foreach ($config as $key => $modules) {

            // Create a new role
            $role = \App\Role::firstOrcreate([
                'name' => $key
            ], [
                'display_name' => $roleLabel[$key]['name'],
                'description' => $roleLabel[$key]['description']
            ]);
            $permissions = [];

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = \App\Permission::firstOrCreate([
                        'name' => $permissionValue . '-' . $module,
                        'display_name' => $actionsLabel[ $permissionValue ] . ' ' . $permissionsLabel[ $module ],
                        'description' => 'امکان ' . $actionsLabel[ $permissionValue ] . ' یک ' . $permissionsLabel[ $module ],
                    ])->id;

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
                }
            }

            // Attach all permissions to the role
            $role->permissions()->sync($permissions);

            $usernames->each( function($username) use($password, $role) {

                $this->command->info("Creating '{$username}' user");
    
                // Create default user for each role
                $user = factory(\App\User::class)->create([
                    'email' => $username,
                    'password' => bcrypt( $password )    
                ]);
                $user->attachRole($role);
            });
        }

        // Creating user with permissions
        if (!empty($userPermission)) {

            foreach ($userPermission as $key => $modules) {

                foreach ($modules as $module => $value) {

                    // Create default user for each permission set
                    $user = factory(\App\User::class)->create([
                        'email' => $username,
                        'password' => bcrypt( $password ),
                        'remember_token' => str_random(10),
                    ]);
                    $permissions = [];

                    foreach (explode(',', $value) as $p => $perm) {

                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = \App\Permission::firstOrCreate([
                            'name' => $permissionValue . '-' . $module,
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ])->id;

                        $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
                    }
                }

                // Attach all permissions to the user
                $user->permissions()->sync($permissions);
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return    void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permission_role')->truncate();
        DB::table('permission_user')->truncate();
        DB::table('role_user')->truncate();
        \App\User::truncate();
        \App\Role::truncate();
        \App\Permission::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
