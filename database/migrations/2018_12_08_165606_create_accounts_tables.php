<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateAccountsTables extends Migration
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
        
        // $schema->create('banks', function (Blueprint $table) {
        //     $table->id('uuid');
        //     $table->info('name');
        //     $table->logo()->nullable();
        //     $table->boolean('is_active')->default(1);
        //     $table->full_timestamps();
        // });
        
        // $schema->create('accounts', function (Blueprint $table) {
        //     $table->table([
        //         'info' => 'param:name',
        //         'name_en' => 'nullable',
        //         'type' => '20|comment:Type of accounts, personal, bank or fund',
        //         'logo' => '150|nullable',
        //         'balance' => 'integer|default:0',
        //         'info' => 'mediumText|nullable',
        //         'is_active' => 'boolean|default:1',
        //     ], [
        //         'groupings' => true,
        //         'banks' => true,
        //     ], 'uuid');
        // });

        // $schema->create('max_debts', function (Blueprint $table) {
        //     $table->integer('max_value')->default(0);
        //     $table->morphs('creditable');
        //     $table->reltoAccounts();
        // });
        
        // $schema->create('persons', function (Blueprint $table) {
        //     $table->table([
        //         'description' => '255|nullable',
        //         'balance' => 'integer|default:0',
        //         'type' => '20|nullable|comment:Type of person, e.g family, friend, workmates etc...',
        //         'is_debtor' => 'boolean|default:0',
        //         'is_active' => 'boolean|default:1',
        //     ], [
        //         'groupings' => true,
        //         'users' => true,
        //     ], 'uuid');
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