<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateLocationTables extends Migration
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

        $schema->create('countries', function (Blueprint $table) {
            $table->table([
                'longitude‎' => '12|nullable',
                'longitude‎' => '12|nullable',
                'name'      => 30,
                'code'      => 4, 
            ], [], 'int', false);
        });

        $schema->create('provinces', function (Blueprint $table) {
            $table->table([
                'longitude‎' => '12|nullable',
                'longitude‎' => '12|nullable',
                'name'      => 30,
            ], ['countries' => false], 'int', false);
        });

        $schema->create('cities', function (Blueprint $table) {
            $table->table([
                'longitude‎' => '12|nullable',
                'longitude‎' => '12|nullable',
                'name'      => 30,
                'users_count'  => 'unsignedInteger|default:0',
            ], ['provinces'], 'int', false);
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
        $schema->dropIfExists('provinces');
        $schema->dropIfExists('cities');
    }
}
