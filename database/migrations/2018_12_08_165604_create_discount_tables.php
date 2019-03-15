<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateDiscountTables extends Migration
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
        
        $schema->create('discounts', function (Blueprint $table) {
            $table->table([
                'sluggable_info',
                'logo'          => 'nullable|array',
                'type'          => 'tinyInteger|nullable',
                'status'        => 'tinyInteger|default:0'
            ], [
                'users',
            ], 'int', ['start_at', 'expired_at']);
        });

        $schema->create('category_discount', function (Blueprint $table) {
            $table->interface('categories', 'discounts');
        });

        $schema->create('discount_items', function (Blueprint $table) {
            $table->table([
                'offer' => 'integer',
                'quantity' => 'integer|nullable',
                'sold_count' => 'integer|default:0'
            ], [
                'discounts',
                'variations'
            ]);
        });

        $schema->create('promocodes', function (Blueprint $table) {
            $table->table([
                'code'          => 50,
                'value'         => 'integer',
                'min_total'     => 'integer|default:0',
                'reward_type'   => '20|default:buy|comment:e.g buy, birthday, gift etc...',
            ], [], 'int', ['expired_at']);
        });

        $schema->create('promocode_variation', function (Blueprint $table) {
            $table->interface('promocodes', 'variations');
        });

        $schema->create('category_promocode', function (Blueprint $table) {
            $table->interface('promocodes', 'categories');
        });

        $schema->create('promocode_user', function (Blueprint $table) {
            $table->interface('promocodes', 'users');
            $table->boolean('is_used')->default(0);
            $table->timestamp('used_at')->nullable();
        });
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