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
                'info',
                'color' => 'nullable|max:12',
                'jalali_created_at' => 'datetime|nullable'
            ], ['tenants']);
        });

        $schema->create('orders', function (Blueprint $table) {
            $table->table([
                'descriptions'      => 'array',
                'destination'       => '255|nullable',
                'postal_code'       => '10|nullable',
                
                'offer'             => 'bigInteger|default:0',
                'total'             => 'bigInteger|default:0',
                'shipping_cost'     => 'integer|default:0',
                'tax'               => 'bigInteger|default:0',

                'docs'              => 'array|comment:Array of documentation images',
                'checkout'          => 'boolean|default:0',
                'ref_id'            => '150|nullable',
                'trans_id'          => '150|nullable',
                // 'payment_jalali'    => 'timestamp',
                'datetimes'         => 'mediumText|nullable',
                'type'              => 'tinyInteger|default:0|comment:Type of factor, e.g sell, buy, sell_back etc...',
                'is_accept'         => 'boolean|default:0',
                'jalali_created_at' => 'datetime|nullable'
            ], [
                'tenants',
                'users',
                'order_statuses',
                'promocodes' => true,
                'shipping_methods' => true,
                'cities' => true,
            ], 'uuid', ['paid_at', 'jalali_paid_at']);            
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
                'variations' => true,
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
