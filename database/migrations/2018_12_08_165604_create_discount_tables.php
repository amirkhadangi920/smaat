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
                // 'info',
                'logo'              => 'nullable|array',
                'type'              => 'tinyInteger|nullable',
                'status'            => 'tinyInteger|default:0',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users',
            ], 'int', ['started_at', 'expired_at']);
        });
        
        $schema->create('discount_translations', function ($table) {
            $table->increments('id');
            $table->integer('discount_id')->unsigned();

            $table->string('title', 50);
            $table->string('description', 255)->nullable();

            $table->string('locale')->index();
            $table->unique(['discount_id','locale']);
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
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
                'code'              => 50,
                'value'             => 'tinyInteger',
                'min_total'         => 'integer|default:0',
                'max'               => 'integer|nullable',
                'quantity'          => 'integer|nullable',
                'reward_type'       => '20|default:buy|comment:e.g buy, birthday, gift etc...',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users'
            ], 'int', ['expired_at']);

            // $table->unique(['code', 'tenant_id']);
        });

        $schema->create('promocode_variation', function (Blueprint $table) {
            $table->interface('promocodes', 'variations');
        });

        $schema->create('category_promocode', function (Blueprint $table) {
            $table->interface('promocodes', 'categories');
        });

        $schema->create('promocode_user', function (Blueprint $table) {
            $table->interface('promocodes', 'users');
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