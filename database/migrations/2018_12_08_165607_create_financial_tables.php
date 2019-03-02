<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateFinancialTables extends Migration
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
        
        // $schema->create('transactions', function (Blueprint $table) {
        //     $table->table([
        //         'value' => 'integer|default:0',
        //         'description' => '255|nullable',
        //         'docs' => 'json|nullable|comment:Array of documentation images',
        //         'type' => 'boolean|default:1|comment:type of transaction, Receive=1 or pay=0',
        //     ], [
        //         'users' => true,
        //         'factors' => true,
        //         'accounts' => true
        //     ]);
        // });
        
        // $schema->create('debt_and_credit', function (Blueprint $table) {
        //     $table->feilds([
        //         'value' => 'integer|default:0',
        //         'description' => '255|nullable',
        //         'docs' => 'json|nullable|comment:Array of documentation images',
        //         'type' => 'boolean|default:1|comment:type of transaction, Receive=1 or pay=0',
        //         'paid' => 'boolean|default:1|comment:status of payment, paid=1 or unpaid=0',
        //     ], [
        //         'accounts' => true,
        //         'users' => true,
        //         'factors' => true,
        //     ], 'int', ['due_at']);     
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