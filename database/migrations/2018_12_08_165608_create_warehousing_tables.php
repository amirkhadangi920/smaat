<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateWarehousingTables extends Migration
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
        
        // $schema->create('warehouses', function (Blueprint $table) {
        //     $table->table([
        //         'info',
        //         'docs'          => 'json|nullable|comment:Array of documentation images',
        //         'is_finished'   => 'boolean|default:0|comment:status of warehouse handling, finished=1 or in progress=0'
        //     ]);
        // });

        // $schema->create('warehouse_items', function (Blueprint $table) {
        //     $table->table([
        //         'prev_inventory'    => 'integer',
        //         'new_inventory'     => 'integer',
        //         'description'       => '255|nullable',
        //         'place'             => '255|nullable',
        //         'docs'              => 'json|nullable|comment:Array of documentation images',
        //         'is_applied'        => 'boolean|default:0|comment:if is applied is true, variation invetory had changed',
        //         'is_created'        => 'boolean|default:0|comment:if the variation create in this warehouse is true',
        //     ], [
        //         'warehouses' => true,
        //         'variations',
        //         'users'
        //     ]);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('factor_items');
        $schema->dropIfExists('factors');
        $schema->dropIfExists('discount_codes');
        $schema->dropIfExists('accounts');
        $schema->dropIfExists('transactions');
    }
}