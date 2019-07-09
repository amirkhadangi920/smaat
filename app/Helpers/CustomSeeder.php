<?php

namespace App\Helpers;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Models\Hostname;

class CustomSeeder extends Seeder
{
    public function createTable($class, $fields, $data = [], $title = null, $helper = null, $count = null)
    {
        $counts = $count ? $count : rand(1, 5);
        
        if ( is_null($title) )
            $title = str_replace('-', ' ', Str::kebab( class_basename($class) ));

        $this->command->warn("Trying to create {$counts} {$title} {$helper}");


        if ( is_object( $class ) )
        {
            $data = $class($counts);
        }
        else 
        {
            $data = factory($class, $counts)->create($data);
        }

        $this->command->table($fields, $data->map( function($item) use($fields) {
            $temp = [];

            foreach($fields as $field)
                $temp[] = $item[$field];

            return $temp;
        }));

        $this->command->info("{$data->count()} {$title} was created {$helper}");

        echo PHP_EOL;

        return $data;
    }

    public function getTenant()
    {
        $tenants = Tenant::with('hostnames')->get();

        if ( $tenants->count() === 0 )
        {
            if ( $this->command->confirm('There aren\'t any tenant in DB, you want to create a new one ?', true) )
                $tenant_id = $this->createTenant();

            else
                return;
        } else {
            $this->command->table(['id', 'title', 'hostnames'], $tenants->map( function($item) {
                return [
                    $item->id,
                    $item->title,
                    implode(', ', $item->hostnames->pluck('domain')->toArray() )
                ];
            }));

            $tenant_id = $this->command->anticipate('Which tenant do you want to create data for it ?', $tenants->map( function($item) {
                return $item->id;
            })->toArray(), 'new');

            if ( $tenant_id === 'new' )
                $tenant_id = $this->createTenant();
        }

        return $tenant_id;
    }

    public function createTenant()
    {
        $tenant = factory(Tenant::class)->create();
        $tenant->hostnames()->save( factory(Hostname::class)->make() );
        
        return $tenant->id;
    }
}