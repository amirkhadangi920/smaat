<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateTenantTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new Blueprint($table, $callback);
        });

        $schema->create('tenants', function (Blueprint $table) {
            $table->table([
                'info'
            ], ['users'], 'uuid');
        });

        $schema->create('hostnames', function (Blueprint $table) {
            $table->table([
                'domain' => '32|unique'
            ], ['tenants']);
        });

        $schema->table('users', function (Blueprint $table) {
            $table->add_foreign('tenants', true, 'uuid');
            $table->unique(['email', 'tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('users');
    }
}
