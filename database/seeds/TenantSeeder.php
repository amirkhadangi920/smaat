<?php

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Helpers\CustomSeeder;

class TenantSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::find( $this->getTenant() );

        $tenant->hostnames()->createMany([
            [
                'domain' => 'localhost'
            ], [
                'domain' => '192.168.1.219'
            ]
        ]);
            
        $this->command->table([
            'id', 'tenant_id', 'domain'
        ], $tenant->hostnames->map( function($item) {
            return [
                $item->id,
                $item->tenant_id,
                $item->domain
            ];
        }));
    }
}
