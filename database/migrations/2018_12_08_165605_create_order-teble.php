<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
class CreateOrderTeble extends Migration
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
        
        $schema->create('order_statuses', function (Blueprint $table) {
            $table->table([
                'color'             => 'nullable|max:12',
                'icon'              => 'nullable|max:50',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'users',
                'tenants' => ['nullable', 'cascade']
            ]);
        });

        $schema->create('order_status_translations', function ($table) {
            $table->increments('id');
            $table->integer('order_status_id')->unsigned();

            $table->string('title', 50);
            $table->string('description', 255)->nullable();

            $table->string('locale')->index();
            $table->unique(['order_status_id','locale']);
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
        });

        $schema->create('orders', function (Blueprint $table) {
            $table->table([
                'coordinates'       => 'point',
                'destination'       => '255|nullable',
                'postal_code'       => '10|nullable',
                'phone_number'      => '15|nullable',
                
                'offer'             => 'bigInteger|default:0',
                'total'             => 'bigInteger|default:0',
                'shipping_cost'     => 'integer|default:0',

                'checkout'          => 'boolean|default:0',
                'ref_id'            => '150|nullable',
                'trans_id'          => '150|nullable',
                'type'              => 'tinyInteger|default:0|comment:Type of factor, e.g sell, buy, sell_back etc...',
                'is_accept'         => 'boolean|default:0',
                'jalali_created_at' => 'datetime|nullable'
            ], [
                'tenants',
                'users',
                'order_statuses',
                'user_phones' => ['nullable', 'set null'],
                'user_addresses' => ['nullable', 'set null'],
                'promocodes' => ['nullable', 'set null'],
                'shipping_methods' => ['nullable', 'set null'],
                'cities' => ['nullable', 'set null'],
            ], 'uuid', ['paid_at', 'jalali_paid_at', 'user_addresses', 'user_phones']);
        });

        $schema->create('order_status_changes', function ($table) {
            $table->reltoOrders();
            $table->reltoOrder_statuses();

            $table->index([ 'order_id', 'order_status_id' ]);
            $table->timestamp('changed_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });

        $schema->create('order_items', function (Blueprint $table) {
            $table->table([
                'count' => 'unsignedInteger',
                'price' => 'unsignedBigInteger|default:0',
                'offer' => 'unsignedBigInteger|default:0',
                'tax'   => 'unsignedBigInteger|default:0',
                'description' => '255|nullable',
            ], [
                // 'users',
                'orders',
                'variations' => ['nullable', 'set null'],
            ],  'uuid');
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
